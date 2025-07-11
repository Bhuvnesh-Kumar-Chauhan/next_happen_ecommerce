<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thank You Page</title>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5MDXMM42');</script>
<!-- End Google Tag Manager -->

<link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Source+Sans+Pro" rel="stylesheet">
<style>

   *{

  box-sizing:border-box;

/* outline:1px solid ;*/

}

body{

background: #ffffff;

background: linear-gradient(to bottom, #ffffff 0%,#e1e8ed 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e1e8ed',GradientType=0 );

    height: 100%;

        margin: 0;

        background-repeat: no-repeat;

        background-attachment: fixed;

}
 
.wrapper-1{

  width:100%;

  height:100vh;

  display: flex;

flex-direction: column;

}

.wrapper-2{

  padding :30px;

  text-align:center;

}

h1{

    font-family: 'Kaushan Script', cursive;

  font-size:4em;

  letter-spacing:3px;

  color:#5892FF ;

  margin:0;

  margin-bottom:20px;

}

.wrapper-2 p{

  margin:0;

  font-size:1.3em;

  color:#aaa;

  font-family: 'Source Sans Pro', sans-serif;

  letter-spacing:1px;

}

.go-home {
      display: inline-block;
      background: #5892FF;
      color: white;
      text-decoration: none;
      padding: 12px 30px;
      border-radius: 30px;
      font-size: 1em;
      transition: 0.3s ease-in-out;
      box-shadow: 0 5px 15px rgba(88, 146, 255, 0.3);
      margin-top:15px;
    }

.footer-like{

  margin-top: auto; 

  background:#D7E6FE;

  padding:6px;

  text-align:center;

}

.footer-like p{

  margin:0;

  padding:4px;

  color:#5892FF;

  font-family: 'Source Sans Pro', sans-serif;

  letter-spacing:1px;

}

.footer-like p a{

  text-decoration:none;

  color:#5892FF;

  font-weight:600;

}
 
@media (min-width:360px){

  h1{

    font-size:4.5em;

  }

  .go-home{

    margin-bottom:20px;

  }

}
 
@media (min-width:600px){

  .content{

  max-width:1000px;

  margin:0 auto;

}

  .wrapper-1{

  height: initial;

  max-width:620px;

  margin:0 auto;

  margin-top:50px;

  box-shadow: 4px 8px 40px 8px rgba(88, 146, 255, 0.2);

}

}
 
</style>
</head>
<body>
    
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5MDXMM42"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="content">
<div class="wrapper-1">
<div class="wrapper-2">
<h1>Thank you! </h1>
<p>Contacting Us</p>
<p>Your message has been successfully sent. We’ll get back to you soon!.</p>
<a href="{{ url('/') }}" class="go-home">Go Home</a>
</div>
</div>

</div>
</body>
</html>
 