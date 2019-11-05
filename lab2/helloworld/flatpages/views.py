# Create your views here.
#!/usr/bin/env python
# -*- coding: utf-8 -*-
from django.http import HttpResponse
def hello(request):
    return HttpResponse('hello world', mimetype="text/plain")
from django.shortcuts import render
def home(request):
 return render(request, 'static_handler.html', {})
