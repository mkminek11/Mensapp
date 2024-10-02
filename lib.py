from dataclasses import dataclass
from datetime import datetime
import json
from typing import Literal
import sqlite3

conn = sqlite3.connect("database.db", check_same_thread=False)
conn.row_factory = sqlite3.Row

c = conn.cursor()


@dataclass
class User:
    id: int
    email: str
    fname: str
    lname: str
    password: str

    def __post_init__(self) -> None:
        self.first_name = self.fname
        self.last_name  = self.lname
        self.name = self.first_name + " " + self.last_name

    def get_chats(self, exclude:list[int] = []) -> list[int]:
        return [r["chat_id"] for r in c.execute("SELECT * FROM `users-chats` WHERE `user_id` = ?", (self.id,)).fetchall()
                if r["chat_id"] not in exclude]
    
    def get_chats_obj(self, exclude:list[int] = []) -> list["Chat"]:
        return [q for r in c.execute("SELECT * FROM `users-chats` WHERE `user_id` = ?", (self.id,)).fetchall()
                if r["chat_id"] not in exclude and (q := Chat.from_id(r["chat_id"]))]

    @classmethod
    def from_db(cls, row:sqlite3.Row) -> "User":
        return User(**dict(row))
        # return User(row["id"], row["email"], row["fname"], row["lname"], row["password"])

    @classmethod
    def from_id(cls, id:int) -> "User":
        return User.from_db(c.execute("SELECT * FROM `users` WHERE `id` = ?", (id,)).fetchone())
    


@dataclass
class Project:
    id: int
    title: str
    description: str
    state: int
    created: int

    def __post_init__(self) -> None:
        self.created_date = datetime.fromtimestamp(self.created)

    @classmethod
    def from_db(cls, row:sqlite3.Row):
        return Project(**dict(row))
        # return Project(row["id"], row["title"], row["description"], row["state"], row["created"])

    @classmethod
    def from_id(cls, id:int):
        return Project.from_db(c.execute("SELECT * FROM `projects` WHERE `id` = ?", (id,)).fetchone())
    


@dataclass
class Message:
    user_id: int
    message: str
    time: int
    deleted: bool
    attachments: list[list[str]] # [("photo.png", "00123_photo.png")]

    # @classmethod
    # def from_string(cls, data:list, users:list[int] = []) -> "Message | Literal[False]":
    #     if len(data) != 6: return False
    #     user, message, time, deleted, attachments = data
    #     if users and int(user) not in users: return False
    #     return Message(int(user), message, datetime.fromtimestamp(int(time)), deleted, attachments)

    @classmethod
    def from_db(cls, row:sqlite3.Row) -> "Message":
        return Message(row["user_id"], row["message"], row["time"], row["deleted"], json.loads(row["attachments"]))
    
    @classmethod
    def from_chat(cls, chat_id:int, max_messages:int = 20, users:list[int] = []) -> "list[Message]":
        data = c.execute("SELECT * FROM `messages` WHERE `chat_id` = ? ORDER BY `time` DESC LIMIT ?", (chat_id, max_messages)).fetchall()
        messages = [Message.from_db(msg) for msg in data]

        if users:
            for m in messages:
                if m.user_id not in users: messages.remove(m)

        # print(messages)
        return messages
    
    @classmethod
    def post(cls, message:str, user_id:int, chat_id:int, attachments:str = ""):
        query = "INSERT INTO `messages` (`chat_id`, `user_id`, `message`, `attachments`) VALUES (?, ?, ?, ?)"
        print(query, chat_id, user_id, message, attachments)
        c.execute(query, (chat_id, user_id, message, attachments))
        conn.commit()



@dataclass
class Chat:
    id: int
    title: str
    messages: list[Message]
    last_message: datetime

    def get_title(self, user:int) -> str:
        users = self.get_users()
        users.remove(user)

        if self.title:
            return self.title
        if len(users) == 0:
            return User.from_id(user).name
        if len(users) == 1:
            return User.from_id(users[0]).name
        else:
            return ",".join([User.from_id(u).name for u in users])

    def get_users(self) -> list[int]:
        return get_chat_users(self.id)
    
    def has_user(self, user_id:int) -> bool:
        return (user_id in self.get_users())

    @classmethod
    def from_id(cls, id:int, load_messages:bool = True) -> "Chat | Literal[False]":
        chat = c.execute("SELECT * FROM `chats` WHERE `id` = ?", (id,)).fetchone()
        if not chat: return False
        users = get_chat_users(id)
        messages = (Message.from_chat(id) if load_messages else [])
        # messages = [m for i in json.loads(chat["messages"]) if (m := Message.from_string(i))]
        return Chat(id, chat["title"], messages, datetime.fromtimestamp(int(chat["last_message"])))
    
    @classmethod
    def last(cls, user:User):
        chats = sorted(user.get_chats(), key = (lambda x: c.last_message if (c := Chat.from_id(x, load_messages = False)) else 0))
        # print(chats, file=sys.stdout)
        return Chat.from_id(chats[0]) if chats else False
    
def get_chat_users(chat_id:int) -> list[int]:
    return [r["user_id"] for r in c.execute("SELECT * FROM `users-chats` WHERE `chat_id` = ?", (chat_id,)).fetchall()]

def get_chat_users_obj(chat_id:int) -> list[User]:
    return [x for r in c.execute("SELECT * FROM `users-chats` WHERE `chat_id` = ?", (chat_id,)).fetchall() if (x := User.from_id(r["user_id"]))]