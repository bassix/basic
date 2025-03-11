{% extends page/auth.html.tpl %}

{% block authform %}
<form method="post" action="/auth/register" class="register-form">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <input type="text" name="email" placeholder="user@domain.tld">
    <button>register</button>
    <p class="message">Already registered? Please <a href="/auth/login">login</a>.</p>
</form>
{% endblock %}
