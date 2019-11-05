# Create your views here.
from models import Article
from django.shortcuts import render
from django.http import HttpResponseRedirect
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
