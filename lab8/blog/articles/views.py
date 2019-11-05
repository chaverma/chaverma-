# Create your views here.
from models import Article
from django.shortcuts import render
from django.http import HttpResponseRedirect
from django.contrib.auth.models import User
from django.contrib.auth import authenticate
from django.contrib.auth import login
def archive(request):
    return render(request, 'archive.html', {"posts":Article.objects.all()})
from django.http import Http404
def get_article(request,article_id):
    try:
        post = Article.objects.get(id=article_id)
        return render(request, 'article.html', {"post": post})
    except Article.DoesNotExist:
        raise Http404
def create_post(request):
    if not request.user.is_anonymous():
        if request.method == "POST":
            form = {'text': request.POST["text"],'title': request.POST["title"]}
            val=form['title']
            if Article.objects.all().filter(title=val):
                form['errors'] = 'not a unique name'
                return render(request, 'create_post.html', {'form': form})
            else:
                if form["text"] and form["title"]:
                    n = Article.objects.create(text=form["text"],title=form["title"],author=request.user)
                    n.save()
                    return HttpResponseRedirect("http://127.0.0.1:8000/article/"+ str(n.pk))
                else:
                    form['errors'] = "not all fields full"
                    return render(request, 'create_post.html', {'form': form})
        else:
            return render(request, 'create_post.html', {})
    else:
        raise Http404
def reg(request):
        if request.method == "POST":
            form = {'login': request.POST["login"],'pass': request.POST["pass"],'mail': request.POST["mail"]}
            if not form["login"]:
                form['error_log'] = "Error(not a login)"
                return render(request, 'registration.html', {'form': form})
            if not User.objects.all().filter(username=form['login']):
                if form["login"] and form["pass"] and form["mail"]:
                    User.objects.create_user(form["login"], form["mail"], form["pass"])
                    return HttpResponseRedirect("http://127.0.0.1:8000")
                if not form["mail"]:
                    form['error_mail'] = "Error(not a mail)"
                    return render(request, 'registration.html', {'form': form})
                if not form["pass"]:
                    form['error_pass'] = "Error(not a pass)"
                    return render(request, 'registration.html', {'form': form})
            else:
                form['error_log'] = "Error(this login is already taken)"
                return render(request, 'registration.html', {'form': form})
        else:
            return render(request, 'registration.html', {})
def auth(request):
        if request.method == "POST":
            form = {'login': request.POST["login"],'pass': request.POST["pass"]}
            if not form['login']:
                form['error_log'] = "Error(please enter login)"
                return render(request, 'authorization.html', {'form': form})
            if not form['pass']:
                form['error_pass'] = "Error(please enter pass)"
                return render(request, 'authorization.html', {'form': form})
            if authenticate(username=form["login"], password=form["pass"]):
                user = authenticate(username=form["login"], password=form["pass"])
                login(request, user)
                return HttpResponseRedirect("http://127.0.0.1:8000")
            else:
                form['error_log'] = "Error(Incorrect login or password)"
                return render(request, 'authorization.html', {'form': form})
        else:
            return render(request, 'authorization.html', {})
