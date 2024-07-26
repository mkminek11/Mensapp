from dataclasses import dataclass
import datetime
import sqlite3

@dataclass
class User:
    id: int
    email: str
    first_name: str
    last_name: str
    password: str

    def __post_init__(self):
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