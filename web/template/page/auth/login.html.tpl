{% extends page/auth.html.tpl %}

{% block authform %}
<form method="post" action="/auth/login" class="login-form">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <button>login</button>
    <p class="message">Not registered? Please <a href="/auth/register">create an account</a>.</p>
</form>
{% endblock %}
