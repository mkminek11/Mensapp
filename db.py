from typing import Any, Callable, Literal
from hashlib import sha1
import sqlite3
from lib import *



def empty(something:Any): return something

def authenticate(email:str, password:str) -> User | Literal[False]:
    user = c.execute("SELECT * FROM `users` WHERE `email` = ? AND `password` = ?", (email, sha1(password.encode()).hexdigest()))
    return User.from_db(user.fetchone()) if user.rowcount else False

def create_account(fname:str, lname:str, email:str, password:str) -> None:
    pwd = sha1(password.encode()).hexdigest()
    c.execute("INSERT INTO `users` (fname, lname, email, password) VALUES (?, ?, ?, ?)", (fname, lname, email, pwd))
    conn.commit()




def get_my_projects(user_id:int, factory:Callable[[sqlite3.Row], Any] = empty) -> list[Project]:
    projects = c.execute("SELECT `projects`.* FROM `users-projects` INNER JOIN `projects` \
                            ON `projects`.`id` = `users-projects`.`project_id` \
                            WHERE `user_id` = ?", (user_id, )).fetchall()
    return [factory(x) for x in projects]