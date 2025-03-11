{% extends layout.html.tpl %}

{% block title %}Pages{% endblock %}

{% block content %}
<div class="container">
    <div class="box">
        <h1>Pages</h1>
        <p>Following pages are available on this website:</p>
        <ul>
            {% foreach($pages as $page): %}
            <li>{{ $page->getTitel() }}</li>
            {% endforeach; %}
        </ul>
    </div>
</div>
{% endblock %}
