from flask import Flask, url_for, redirect, request, render_template, session
from db import *



app = Flask(__name__)
app.secret_key = "4vsr4g8sc4z6r5h4s86th478sr4tvgzs"



@app.route("/", methods = ["POST", "GET"])
def index():
    if request.method == "GET":
        return render_template("index.html", message = request.args.get("m", ""))
    else:
        email    = request.form.get("email", "")
        password = request.form.get("password", "")
        if not (email and password): return redirect("/?m=Please fill in both email and password.")

        if (u := authenticate(email, password)):
            # Authentication successful
            session.permanent = True
            session["user"] = u.id
            return redirect("/projects")
        else:
            # Wrong password
            return redirect("/?Wrong email or password.")
        

@app.route("/signup", methods = ["POST", "GET"])
def sign_up():
    if request.method == "GET":
        # Page opened
        return render_template("signup.html")
    else:
        # Form submitted
        email    = request.form.get("email", "")
        password = request.form.get("password", "")
        fname    = request.form.get("fname", "")
        lname    = request.form.get("lname", "")

        if not (email and password and fname and lname): return redirect("/signup?m=Please fill in all informations.")

        create_account(fname, lname, email, password)
        return redirect("/projects")
    

@app.route("/projects")
def projects():
    if not isinstance((user_id := session.get("user", "")), int) or user_id == 0: return redirect("/?You have to log in first.")

    proj = get_my_projects(user_id, Project.from_db)
    return render_template("/projects.html", projects = proj)



if __name__ == "__main__":
    app.run(debug = True)