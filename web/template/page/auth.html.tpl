{% extends layout.html.tpl %}

{% block title %}{{ $title }} Page{% endblock %}

{% block content %}
<div class="container">
    <div class="box">
        {% yield authform %}
    </div>
</div>
{% endblock %}
