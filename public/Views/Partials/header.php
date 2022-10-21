<!-- Header -->
<amp-sidebar id="sidebar" class="sample-sidebar" layout="nodisplay" side="left">
    <div class="close-menu">
        <a on="tap:sidebar.toggle">
            <img src="{{URL}}/public/assets/images/bt-close.png" alt="Close Menu" width="24" height="24" />
        </a>
    </div>
    <a href="{{URL}}/">
        <img src="{{URL}}/public/assets/images/menu-go-jumpers.png" alt="Welcome" width="200" height="43" />
    </a>
    <div>
        <ul>
            <li><a href="{{URL}}/categories" class="link-menu">Categories</a></li>
            <li><a href="{{URL}}/products" class="link-menu">Products</a></li>
        </ul>
    </div>
</amp-sidebar>

<header>
    <div class="go-menu">
        <a on="tap:sidebar.toggle">☰</a>
        <a href="{{URL}}" class="link-logo">
            <img src="{{URL}}/public/assets/images/go-logo.png" alt="Welcome" width="69" height="430" />
        </a>
    </div>
    <div class="right-box">
        <span class="go-title">Administration </span>
    </div>    
</header>  
<!-- Header -->