<!DOCTYPE html>
<html lang="en">
@include("layouts.dashboard.parts.header")
<body id="body" class="app sidebar-mini rtl">
<script>

const box = document.getElementById('body');

var target = document.querySelector("#body");
target.innerHTML += '<div class="loader-div"><span class="loader"><img class="app-sidebar__user-avatar" src="http://dashboard.fattehsanawbar.digisolapps.com/uploads/splash-screen.gif" alt="User Image"></span></div>';



</script>        

<!-- Navbar-->
@include("layouts.dashboard.parts.navbar")

<!-- Sidebar menu-->
@include("layouts.dashboard.parts.slidebar")
<main class="app-content">
    
    
    
    @hasSection("page-nav-title")
        @yield("page-nav-title")
    @endif
    @yield("content")
</main>
    @include("layouts.auth.parts.footer")
</body>


<script>        
        
        $(window).on('load', function(){
            
        setTimeout(removeLoader, 2000); //wait for page load PLUS two seconds.
        });


function removeLoader(){
$( ".loader-div" ).fadeOut(500, function() {
// fadeOut complete. Remove the loading div
$( ".loader-div" ).remove(); //makes page more lightweight 
});  
}
    
</script>


</html>
