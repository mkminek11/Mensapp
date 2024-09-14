import os
from flask import Flask, jsonify, url_for, redirect, request, render_template, session
from db import *
from werkzeug.utils import secure_filename


app = Flask(__name__)
app.secret_key = "4vsr4g8sc4z6r5h4s86th478sr4tvgzs"



@app.route("/", methods = ["POST", "GET"])
def index():
    if request.method == "GET":
        if session.get("user", ""): return redirect("/projects")
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
    if not isinstance((user_id := int(session.get("user", "0"))), int) or user_id == 0: return redirect("/?You have to log in first.")

    proj = get_my_projects(user_id, Project.from_db)
    return render_template("/projects.html", projects = proj)


@app.route("/project/<project>")
def project(project:str):
    if not isinstance((user_id := int(session.get("user", "0"))), int) or user_id == 0: return redirect("/?You have to log in first.")

    return render_template("project.html", project = Project.from_id(int(project)))


@app.route("/chat/<chat_i>")
def chat(chat_i:str):
    if not (user_id := int(session.get("user", "0"))): return redirect("/?You have to log in first.")
    if not (c := Chat.from_id(int(chat_i))): return redirect("/chat")

    return render_template("chat.html", user = User.from_id(user_id), chat = c)



@app.route("/chat")
def chat_default():
    if not (user_id := int(session.get("user", "0"))): return redirect("/?You have to log in first.")

    return render_template("chat.html", user = User.from_id(user_id), chat = Chat.last(User.from_id(user_id)))


@app.route("/_upload", methods = ["POST"])
def _upload():
    if not (user_id := int(session.get("user", "0"))): return redirect("/?You have to log in first.")
    real_names = []

    files = request.files.lists()
    for n, files in files:
        name, type = secure_filename(n).rsplit(".", 1)
        target_folder = os.path.join("static", "user_upload")
        file_name = f"{len(os.listdir(target_folder)):0>4}_{name}.{type}"

        files[0].save(os.path.join(target_folder, file_name))
        real_names.append(file_name)

    return "\n".join(real_names)


@app.route("/_send", methods = ["POST"])
def _send():
    if not (user_id := int(session.get("user", "0"))): return redirect("/?You have to log in first.")
    chat_id = request.form.get("chat", 0, int)
    # if user is not a member of given chat
    if (not chat_id) or (not session["user"] in get_chat_users(chat_id)): return ""
    Message.post(request.form.get("message", ""), user_id, chat_id, request.form.get("attachments", "[]"))
    return ""


@app.route("/_get_messages")
def _get_messages():
    if not (user_id := int(session.get("user", "0"))): return redirect("/?You have to log in first.")
    chat = Chat.from_id(request.args.get("chat", 0, int))
    if not chat: return ""
    return jsonify(list(reversed([[m.user_id, user_id, m.message, m.attachments] for m in chat.messages])))



if __name__ == "__main__":
    app.run(debug = True)