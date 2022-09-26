jQuery(document).ready(function(a){a("#widgets-right").on("click",".gspw-tab-item",function(b){b.preventDefault();var c=a(this).parents(".widget");console.log(c),c.find(".gspw-tab-item").removeClass("active"),a(this).addClass("active"),c.find(".gspw-tab").addClass("gspw-hide"),c.find("."+a(this).data("toggle")).removeClass("gspw-hide")})});

jQuery(document).ready(function($) {
    $(".gspw-tab-display p:nth-child(1) select option:nth-child(n+3)").attr('disabled','disabled');
});