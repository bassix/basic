{% extends layout.html.tpl %}

{% block title %}{{ $title }}{% endblock %}

{% block content %}
<div class="container">
    <div class="box">
        <h1>Bluepoints of this website</h1>
        <p>Here some bluepoints:</p>
        <ul>
            {% foreach($bluepoints as $bluepoint): %}
            <li>{{ $bluepoint }}</li>
            {% endforeach; %}
        </ul>
    </div>
</div>
{% endblock %}
