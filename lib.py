from dataclasses import dataclass
import datetime
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

    def __post_init__(self):
        self.first_name = self.fname
        self.last_name  = self.lname
        self.name = self.first_name + " " + self.last_name

    @classmethod
    def from_db(cls, row:sqlite3.Row):
        return User(**dict(row))
        # return User(row["id"], row["email"], row["fname"], row["lname"], row["password"])
    

@dataclass
class Project:
    id: int
    title: str
    description: str
    state: int
    created: str

    def __post_init__(self):
        self.created_date = datetime.datetime.strptime(self.created, r"%Y-%m-%d")

    @classmethod
    def from_db(cls, row:sqlite3.Row):
        return Project(**dict(row))
        # return Project(row["id"], row["title"], row["description"], row["state"], row["created"])

    @classmethod
    def from_id(cls, id:int):
        return Project.from_db(c.execute("SELECT * FROM `projects` WHERE `id` = ?", (id,)).fetchone())