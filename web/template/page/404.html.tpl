{% extends layout.html.tpl %}

{% block title %}Page not found!{% endblock %}

{% block content %}
<div class="container notfound">
    <div class="box notfound">
        <h1>Uuups! This page is <strong><em>not</em></strong> available :(</h1>
        <h2>Sorry you get lost in the space!</h2>
        <h3 class="notfound_letter">4&#129302;4</h3>
        <form>
            <input type="button" onclick="window.location.href = '/';" value="let´s go to the main page"/>
        </form>
    </div>
</div>
{% endblock %}
