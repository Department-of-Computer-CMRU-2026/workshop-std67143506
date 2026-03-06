<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ config('app.name', 'Laravel') }} - Register</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>

*{
box-sizing:border-box;
}

body{
font-family:'Outfit',sans-serif;
min-height:100vh;
display:flex;
align-items:center;
justify-content:center;
margin:0;
overflow:hidden;

background:linear-gradient(
270deg,
#ffd1dc, /* soft pink */
#e6e6fa, /* soft lavender */
#ffdab9, /* light peach */
#e6e6fa
);

background-size:600% 600%;
animation:bgMove 25s ease infinite; /* Slower animation for comfort */
}

@keyframes bgMove{
0%{background-position:0% 50%}
50%{background-position:100% 50%}
100%{background-position:0% 50%}
}


/* glowing blobs */

.blob{
position:absolute;
width:800px;
height:800px;
border-radius:50%;
filter:blur(150px);
opacity:.45; /* Much softer opacity */
z-index:-1;
animation:float 35s infinite alternate ease-in-out;
}

.blob1{
background:#ffc0cb; /* soft pink blob */
top:-300px;
left:-200px;
}

.blob2{
background:#dda0dd; /* soft plum blob */
bottom:-300px;
right:-200px;
animation-delay:-12s;
}

@keyframes float{
from{transform:translate(0,0) scale(1)}
to{transform:translate(200px,120px) scale(1.4)}
}


/* glass card */

.card{
width:100%;
max-width:480px;

padding:40px 55px;

border-radius:40px;

background:rgba(255,255,255,0.85); /* More opaque for contrast */

backdrop-filter:blur(30px);
-webkit-backdrop-filter:blur(30px);

border:1px solid rgba(255,255,255,.5);

box-shadow:
0 30px 80px rgba(0,0,0,.15),
inset 0 0 0 1px rgba(255,255,255,.5);

color:#18181b; /* zinc-900 for readability */

text-align:center;
}


/* logo */

.logo{
width:70px;
height:70px;

margin:auto;
margin-bottom:20px;

border-radius:20px;

display:flex;
align-items:center;
justify-content:center;

background:rgba(255,154,162,0.15); /* Soft pink tint for logo box */

border:1px solid rgba(255,154,162,0.3);
}


/* title */

h1{
font-size:2.2rem;
font-weight:800;
margin-bottom:5px;
}

.subtitle{

font-size:.7rem;
letter-spacing:4px;
text-transform:uppercase;
font-weight:700;

opacity:.85;
margin-bottom:30px;
}


/* inputs */

.input{
width:100%;
padding:14px 18px;

margin-bottom:12px;

border-radius:14px;

border:1px solid rgba(0,0,0,.1);

background:rgba(255,255,255,.6);

color:#18181b;

font-size:0.95rem;

outline:none;

transition:.3s;
}

.input::placeholder{
color:rgba(0,0,0,.45);
}

.input:focus{
border-color:#ff9aa2;
background:white;
transform:scale(1.02);
}


/* button */

.btn{

width:100%;

padding:16px;

border:none;

border-radius:16px;

font-size:1.05rem;

font-weight:800;

color:white;

cursor:pointer;

background:linear-gradient(
135deg,
#ff9aa2,
#ffb7b2,
#c084fc
);

box-shadow:
0 10px 30px rgba(255, 154, 162, 0.3);

transition:.35s;

margin-top:10px;
}

.btn:hover{

transform:translateY(-4px);

box-shadow:
0 20px 40px rgba(255,0,150,.55);

}


/* footer */

.footer{

margin-top:25px;

font-size:.85rem;

opacity:.9;
}

.footer a{

color:#db2777;

font-weight:700;

text-decoration:none;

border-bottom:1px solid rgba(219,39,119,.4);
}

</style>

</head>


<body>

<div class="blob blob1"></div>
<div class="blob blob2"></div>


<div class="card">

<div class="logo">

<svg width="40" height="40" fill="#db2777" viewBox="0 0 24 24">
<path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
</svg>

</div>

<h1>Create Account</h1>
<div class="subtitle">Join our community</div>

<!-- Session Status -->
<x-auth-session-status class="subtitle" style="text-transform: none; color: #4ade80; margin-bottom: 20px; letter-spacing: normal;" :status="session('status')" />

<!-- Validation Errors -->
@if ($errors->any())
    <div class="subtitle" style="text-transform: none; color: #f87171; margin-bottom: 20px; letter-spacing: normal; font-size: 0.75rem;">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif


<form method="POST" action="{{ route('register.store') }}">

@csrf

<input
class="input"
type="text"
name="name"
placeholder="Full name"
value="{{ old('name') }}"
required
autofocus
>

<input
class="input"
type="email"
name="email"
placeholder="Email address"
value="{{ old('email') }}"
required
>

<input
class="input"
type="password"
name="password"
placeholder="Password"
required
>

<input
class="input"
type="password"
name="password_confirmation"
placeholder="Confirm password"
required
>


<button class="btn">
Create Account
</button>

</form>


<div class="footer">

Already have an account?
<a href="{{ route('login') }}">Log in</a>

</div>

</div>


</body>
</html>
