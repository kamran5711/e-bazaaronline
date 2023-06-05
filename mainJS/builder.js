function hideme(e) {}

function breakcreator(e) {
    if (window.getSelection) {
        e.stopPropagation();
        var t = window.getSelection(),
            a = t.getRangeAt(0),
            n = document.createElement("br");
        return a.deleteContents(), a.insertNode(n), a.setStartAfter(n), a.setEndAfter(n), a.collapse(!1), t.removeAllRanges(), t.addRange(a), !1
    }
    return !0
}

function init_load() {
    loadMap(), init_slideShow(), drophoverMenu(), init_parallax(), init_lightBox(), innerSortable(), init_masonry(), validateForm()
}

function init_lightBox() {
    $(".open_lightbox").length > 0 && $(".open_lightbox").lightGallery({
        hash: !1,
        preload: 0,
        download: !1
    })
}

function init_insta(e) {
    e ? instaElement = e : instaElement = $(".instafeed"), instaElement.each(function() {
        $(this).empty();
        var e = $(this).attr("data-insta-username"),
            t = $(this).attr("data-insta-wrapper"),
            a = $(this).attr("data-insta-length");
        $(this).spectragram("getUserFeed", {
            query: e,
            max: a,
            wrapEachWith: t
        })
    })
}

function innerSortable(e) {
    if (void 0 == e || null == e) {
        $(".omg_component").find("div.row , div.container , .nav").not(".masonry").not("div[contenteditable]").sortable({
            cancel: "[contenteditable], nav, input, textarea",
            opacity: 1,
            scroll: !0,
            opacity: 1,
            cursor: "move",
            activate: function(e, t) {
                $(t.item).addClass("opacity"), $(t.item).parents(".ui-sortable").addClass("dragstart"), $(t.item).addClass("current")
            },
            stop: function(e, t) {
                $(t.item).removeClass("opacity"), $(t.item).parents(".ui-sortable").removeClass("dragstart"), $(t.item).removeClass("current")
            }
        })
    }
    "destroy" == e && $(".omg_component").find("div.row , div.container").sortable("destroy")
}

function close_sidebar(e, t) {
    "all" == t ? $("aside").removeClass("visible") : e ? $(t).removeClass("visible") : 0 == mouse_in_asidemenu && $(t).removeClass("visible")
}

function pushWork(e, t) {
    styleAtt1 = t, void 0 == styleAtt1 && (styleAtt1 = ""), undo.push([e, styleAtt1])
}

function popWork() {
    temp = undo.pop(), temp[0].attr("style", ""), temp[0].attr("style", temp[1])
}

function testAnim(e) {
    $("#animationSandbox").removeClass().addClass(e + " animated").one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function() {
        $(this).removeClass()
    })
}

function globalfont() {
    $("#global .font-select").remove(), $("#fontforallbody").fontselect().change(function() {
        var e = $(this).val().replace(/\+/g, " ");
        ex_fontlist.push($(this).val());
        var t = "";
        if (e.indexOf(":") > 0) {
            var a = e.split(":").pop();
            t = "font-weight:" + a + ";";
            var n = e.indexOf(":");
            e = e.substring(0, -1 != n ? n : e.length)
        }
        $("#fontchangerbody").empty().append("body{font-family:" + e + ";" + t + "}")
    }), $("#fontforall").fontselect().change(function() {
        ex_fontlist.push($(this).val());
        var e = $(this).val().replace(/\+/g, " "),
            t = "";
        if (e.indexOf(":") > 0) {
            var a = e.split(":").pop();
            t = "font-weight:" + a + ";";
            var n = e.indexOf(":");
            e = e.substring(0, -1 != n ? n : e.length)
        }
        $("#fontchangertitle").empty().append(".title{font-family:" + e + ";" + t + "}")
    })
}

function color_picker() {
    $(".color").spectrum({
        showAlpha: !0,
        preferredFormat: "rgb",
        showInitial: !0,
        showButtons: !1,
        allowEmpty: !1,
        showInput: !0,
        move: function(e) {
            cur_text_element.css(current_edit_color, e.toString())
        }
    })
}

function init_slideShow() {
    $(".slideshow:not(.slick-initialized)").slick({
        dots: !0,
        infinite: !0,
        speed: 400,
        fade: !0,
        arrows: !0,
        cssEase: "linear",
        accessibility: !1,
        variableWidth: !1
    })
}

function background_color(e, t, a) {
    var n = t,
        o = n.css("background-color").toString();
    $(".badge_abs").find(a).attr("value", o), $(".badge_abs").find(a).spectrum({
        showAlpha: !0,
        preferredFormat: "rgb",
        showInput: !0,
        showInitial: !0,
        showButtons: !1,
        allowEmpty: !1,
        move: function(e) {
            n.css("background-color", e.toString())
        }
    })
}

function imageRatio() {
    $("#medialibrary .modal_gallery img").on("load").each(function() {
        $(this).parent("a").find("span").remove(), $(this).parent("a").append('<span class="sizee">' + $(this).get(0).naturalWidth + "px X " + $(this).get(0).naturalHeight + "px</span>")
    })
}

function imgError(e) {
    $(e).parents(".modal_gallery").remove()
}

function flushwidget() {
    $(".widget_box").addClass("hidden"), cur_slideshow_slide = null, current_edit = null, cur_text_element = null, cur_text_element2 = null, cur_img = null, cur_slideshow = null
}

function RightContextMenu(e) {
    fake_var = e;
    var t = $(window).width() / 2;
    t < e.clientX ? ($("#contextmenu > .dropdown-menu").removeClass("pull-left"), $("#contextmenu > .dropdown-menu").addClass("pull-right")) : ($("#contextmenu > .dropdown-menu").removeClass("pull-right"), $("#contextmenu > .dropdown-menu").addClass("pull-left")), 0 == sortBegin && (e.preventDefault(), $("#contextmenu").position({
        my: "left+3 bottom-3",
        of: e,
        collision: "fit"
    }), $("#tagname").text(e.target.tagName), $("#contextmenu").addClass("open"), ($(e.target).hasClass("icon") || "A" == e.target.parentNode.tagName) && (cur_Icon = $(e.target), $("#tagname").text("Icon"), targetAnchor = $(e.target.parentNode)), "A" == e.target.tagName && (targetAnchor = $(e.target)), ("IMG" == e.target.tagName || "A" == e.target.parentNode.tagName) && (targetAnchor = $(e.target.parentNode), media_setup_for = "img", cur_img = $(e.target).closest("img")), $(e.target).is("div") && ($("#tagname").text("Block"), $(e.target).addClass("outline")))
}

function init_parallax(e) {
    "destroy" == e ? $.stellar("destroy") : ($(window).stellar({
        horizontalScrolling: !1,
        verticalScrolling: !0,
        responsive: !0,
        hideDistantElements: !0
    }), $.stellar("refresh"))
}

function loadStyleSheet() {
    $("#loadprojectstylediv ,  #loadprojectstyle").load("css/style.css", function(e, t, a) {
        "error" == t && console.log("Sorry but there was an error in loading stylesheet: " + a.status + " " + a.statusText)
    })
}

function preventFormSubmit() {
    $(".omg_browser form").on("submit", function(e) {
        e.preventDefault()
    })
}

function init_masonry() {
    $(".active_page .masonry-container").imagesLoaded(function() {
        $(".active_page .masonry-container").masonry({
            gutter: 0
        })
    })
}

function saveProject() {
    $("#htmlsanit").append($(".omg_browser").clone().html()), $("#htmlsanit .omg_browser .omg_page").each(function() {
        $("[contenteditable]").removeAttr("contenteditable"), $("#htmlsanit .omg_page .ui-sortable-handle[style]").each(function() {
            var e = $(this).attr("style");
            e = e.replace("position: relative; opacity: 1;", ""), "" == e ? $(this).removeAttr("style") : $(this).attr("style", e), $(this).removeClass("ui-sortable-handle")
        }), $("#htmlsanit .ui-sortable").removeClass("ui-sortable"), $("#htmlsanit .ui-sortable-handle").removeClass("ui-sortable-handle")
    }), $("#htmlsanit").removeClass("omg-text"), $("#htmlsanit .parallax-content").css("background-position", ""), $("#htmlsanit .instafeed").empty(), $("#htmlsanit .slideshow").each(function() {
        $(this).removeClass("slick-slider"), $(this).removeClass("slick-initialized");
        var e = $(this).find(".slide").removeAttr("style").removeAttr("data-slick-index").removeAttr("class").addClass("slide").removeAttr("aria-hidden");
        $(this).empty(), $(this).append(e)
    }), $("#htmlsanit .masonry-container").masonry().masonry("destroy");
    var e, t = $("#htmlsanit").html(),
        a = window.location.href;
    if (a.indexOf(".php") > -1 || a.indexOf(".html") > -1) var e = a.substring(0, a.lastIndexOf("/"));
    else e = a;
    t.search(e) > 0 && (t = t.replace(e, ""), t = t.replace("url(/", "url("), t = t.replace('url("/', 'url("'));
    var n = new JSZip;
    n.file(projects_pages, t), n.file(project_menu, $(".page_list").html());
    var o = n.generate({
            type: "blob"
        }),
        i = $("#ProjectName").val() + ".prj";
    saveAs(o, i), $("#htmlsanit").empty()
}

function isEmpty() {
    return $(".active_page .omg_component").length > 0 ? ($(".omg_page").css("background-color", "#FAFAFA"), !0) : 0 == $(".active_page .omg_component").length ? ($(".omg_page").css("background-color", "transparent"), !1) : void 0
}

function demoMenu() {
    $("#DemoMenu").toggleClass("hidden").promise().done(function() {
        setTimeout(function() {
            $("#dsr .demo").toggleClass("t")
        }, 30)
    })
}

function validateForm() {}

function openMenu(e) {
    close_sidebar("", "all"), $(e).addClass("visible")
}


//publishFOrm
document.name = "Stallion", document.projectName = "Zaira Client Admin", document.title = document.projectName;
var dropframe = $(".omg_page.active_page"),
    editor, currentEditForm, media_setup_for, ele, background_image, animateClasses = "bounce flash pulse rubberBand shake swing tada wobble bounceIn bounceInDown bounceInLeft bounceInRight bounceInUp bounceOut bounceOutDown bounceOutLeft bounceOutRight bounceOutUp fadeIn fadeInDown fadeInDownBig fadeInLeft fadeInLeftBig fadeInRight fadeInRightBig fadeInUp fadeInUpBig fadeOut fadeOutDown fadeOutDownBig fadeOutLeft fadeOutLeftBig fadeOutRight fadeOutRightBig fadeOutUp fadeOutUpBig flip flipInX flipInY flipOutX flipOutY lightSpeedIn lightSpeedOut rotateIn rotateInDownLeft rotateInDownRight rotateInUpLeft rotateInUpRight rotateOut rotateOutDownLeft rotateOutDownRight rotateOutUpLeft rotateOutUpRight hinge rollIn rollOut zoomIn zoomInDown zoomInLeft zoomInRight zoomInUp zoomOut zoomOutDown zoomOutLeft zoomOutRight zoomOutUp",
    $textTypes = " .omg_page a, .omg_page .icon,.omg_page h1 , .omg_page h2 , .omg_page h3 ,.omg_page  h4 , .omg_page h5 ,  .omg_page h6 , .omg_page span , .omg_page p , .omg_page .hero_text, .omg_page .hero-subtitle, .omg_page .hero_para, .omg_page .hero-title , .omg-text",
    set_contentEditable = !0,
    targetAnchor, fake_var, parallaxclass, sortBegin = !1,
    ex_fontlist = ["Montserrat"],
    total_unsplash_img = 1034,
    windowW = $(window).width() + 150,
    windowH = $(window).height() + 150,
    image_resolution_for_unsplash = windowW + "/" + windowH,
    no_img_page = 20,
    img_remain = 0,
    bg_prepend = $("#bg_prepend"),
    currentEditMap;
Pace.on("done", function() {
    $(".add_component").trigger("click")
}), $(document).on("keydown", "[contenteditable=true]", function(e) {
    return 13 === e.keyCode ? breakcreator(e) ? !0 : !1 : void 0
}), $(".property_sidebar").draggable({
    axis: "x",
    handle: ".drag-heading",
    containment: "parent",
    cursor: "move"
}), $(document).on("blur keyup paste input", "[contenteditable]", function(e) {
    if ("paste" == e.type) {
        e.preventDefault();
        var t = (e.originalEvent || e).clipboardData.getData("text/plain").replace(/\n/g, "<br>");
        document.execCommand("insertHtml", !1, t)
    }
    "keyup" == e.type && "" == $(this).text() && $(this).html("&nbsp;"), "input" == e.type
}), $(document).on("click", ".omg_page a", function(e) {
    e.preventDefault()
}), init_load(), $(document).on("mouseenter", ".omg_component .video_iframe", function() {
    $(".widget_box.videocontrol").removeClass("hidden").css("top", $(this).offset().top - 60).css("left", $(this).offset().left), targetVideoIframe = $(this), $(".widget_box.videocontrol a").attr("href", targetVideoIframe.attr("src"))
});
var targetinstacontrol;
$(document).on("click", ".widget_box.instacontrol a", function(e) {
    e.preventDefault();
    var t = prompt("Enter instagram username", $(this).attr("data-username-insta"));
    0 != t.length && (targetinstacontrol.attr("data-insta-username", t), targetinstacontrol.empty(), init_insta(targetinstacontrol))
}), $(document).on("mouseleave", "div:not(.widget_box.videocontrol)", function() {});
var Components_list;
 

$.getJSON("./builder/components/components.json", function(e) {
    Components_list = e.components;
    
    for (var t in e.components)
        

        for (niceKey = t.toLowerCase().replace(" ", "_"), 
            $('<li><a href="#" data-menu-item="omg_component_' + niceKey + '">' + t + "</a></li>").appendTo("#Menufilter"),          
            x = 0; 

            x < e.components[t].length; x++) newItem = $('<div class="omg_item omg_component_' + niceKey + ' " data-url="' + e.components[t][x].url + '" data-componentname="' + e.components[t][x].name + '"><span>' + e.components[t][x].name + '</span><img src="' + e.components[t][x].thumbnail + '"></div>'), newItem.appendTo("#componentdrawer")
}).error(function() {
    console.error("Please double check the formatting of your JSON file."), console.log("error JSON formatting invalid")
}),$(".api_theme").click( function(){
    $("#api_theme").val($(this).val());

}),
$('.search-api-option').on('change', function() {
    var chkd = $('.search-api-option:checkbox:checked');
        var vals = chkd.map(function() {
            return this.value;
        })
        .get().join(', ');
        //alert( vals );
        $("#search-api-option").val(vals);
    
})
, $(document).on("click", ".omg_item:not(.omg_component_navigation )", function(e) {
    e.preventDefault(), isEmpty();

    var t = $(this).attr("data-url") + "  .omg_component",
        a = $(this).clone(),
        n = $(this).attr("data-componentname");

        var res =n.split("_");
        
         

         if(res[0]=='partners'){

            $(".partners").remove();
           // var e = $(this).children().attr("data-componentname", n).appendTo(".pages");
  

         }


         if(res[0]=='flights'){

            $(".flights").remove();
           // var e = $(this).children().attr("data-componentname", n).appendTo(".pages");
  

         }
         
         if(res[0]=='destinations'){

            $(".destinations").remove();
           // var e = $(this).children().attr("data-componentname", n).appendTo(".pages");
  

         }

         if(res[0]=='deals'){

            $(".deals").remove();
           // var e = $(this).children().attr("data-componentname", n).appendTo(".pages");
  

         }



    $("html, body").animate({
    }, 300), $("#dummy").load(t, function() {
         

        var res =n.split("_");
        
        
        if(res[0]=='header'){
            $("#header_theme").val(n);   
            $(".header").html('');
            var e = $(this).children().attr("data-componentname", n).appendTo(".header");
  
         }else if(res[0]=='search'){
            
             console.log($(this).children().attr("data-componentname"));
             $("#search_theme").val(n);   
            
            $(".searchContent").html('');

             var e = $(this).children().attr("data-componentname", n).appendTo(".searchContent");
       

         }else if(res[0]=='flights'){


            $("#flights_theme").val(n);   
            
            var e = $(this).children().attr("data-componentname", n).appendTo(".contnent");
  

         }else if(res[0]=='destinations'){
             
            $("#destinations_theme").val(n);   
            
            var e = $(this).children().attr("data-componentname", n).appendTo(".contnent");
      // var e = $(this).children().attr("data-componentname", n).appendTo(".pages");
  

         }else if(res[0]=='deals'){
            $("#deals_theme").val(n);   
            var e = $(this).children().attr("data-componentname", n).appendTo(".contnent");
  // var e = $(this).children().attr("data-componentname", n).appendTo(".pages");
  

         }else if(res[0]=='partners'){
             
             $("#partners_theme").val(n);
             var e = $(this).children().attr("data-componentname", n).appendTo(".contnent");
  
         }
         else if(res[0]=='footer'){
            $("#footer_theme").val(n);   
            $(".footer").html('');
            var e = $(this).children().attr("data-componentname", n).appendTo(".footer");
  

         }

       //e.find(".parallax-content").attr("data-stellar-background-ratio", .5), e.find(".instafeed").length > 0 && init_insta(e.find(".instafeed")), init_load(), isEmpty()
    
                var  div = $('.'+res[0]).first().position();    

       $('html, body').animate({
        scrollTop: $('.'+res[0]).offset().top
    }, 2000);


    })
}), $(document).on("click", ".omg_component_navigation", function(e) {
    e.preventDefault();

    var t = $(this).attr("data-url") + "  .omg_component",
        a = $(this).clone(),
        n = ($(this).attr("data-componentname"), $(a).prependTo(".omg_page.active_page"));
    $("#dummy").load(t, function(e) {
        n.remove(), $(".active_page .cntrl-nav").remove(), $(".omg_page.active_page").prepend(e), $("html, body").animate({
            scrollTop: 0
        }, 300), isEmpty(), init_load()
    })
});

$("#publishbutton").click( function(){
   $("#publishFOrm").submit();
})
var newIcon, cur_Icon;
$("#icons_load").load("builder/icons", function() {}), $(document).on("click", "#showall", function(e) {
    e.preventDefault(), $("#icons li").removeClass("hidden")
}), $(document).on("keydown", "#searchicon", function(e) {
    console.log("happend"), $("#icons li").addClass("hidden"), console.log($("#icons li[data-tags*='" + $(this).val() + "']")), $("#icons li[data-tags*='" + $(this).val() + "']").removeClass("hidden")
}), $(document).on("click", "#icons li", function(e) {
    e.preventDefault(), newIcon = $(this).attr("class"), $(".selected_icon").removeClass("selected_icon"), $(this).addClass("selected_icon")
}), $(document).on("click", "#updateIcon", function(e) {
    e.preventDefault();
    var t = cur_Icon.attr("class");
    cur_Icon.removeAttr("class"), t = t.replace(/(?:^|\W)ion-[-\w]*/g, " " + newIcon), cur_Icon.attr("class", t), $("#icons").modal("hide")
}), $(".modal").on("shown.bs.modal", function(e) {
    $("aside").removeClass("visible")
});
var current_filter, mouseinSubmenu;
$(document).on("click", "#Menufilter li a", function(e) {
    $(".property_sidebar").hide();    
    $(".leftSubm li a").removeClass('active');
    $("#subMenu").addClass('visible');

    e.preventDefault(), current_filter = $(this).attr("data-menu-item"), $("#componentdrawer").scrollTop(0), $("#componentdrawer .omg_item").addClass("hidden"), $("#componentdrawer ." + current_filter).removeClass("hidden"), $("#Menufilter li").removeClass("active"), $(this).addClass("active"), "all" == current_filter ? ($("#componentdrawer .omg_item").removeClass("hidden"), $("#filtername").text("filters")) : $("#filtername").text($(this).text())
}), mouse_in_asidemenu = !1, $(".add_component").click(function(e) {
    e.preventDefault(), $("aside").removeClass("visible"), $("#subMenu").addClass("visible")
}), $(document).on("mouseleave", "#subMenu", function() {
    mouse_in_asidemenu = !1, close_sidebar(!0, ".property_sidebar"), setTimeout(function() {
        close_sidebar(!1, "#subMenu")
    }, 5e3)
}), $(document).on("mouseenter", ".property_sidebar , #subMenu", function() {
    mouse_in_asidemenu = !0
}), $(document).on("mouseenter", "#anchorMenu", function() {
    mouse_in_asidemenu = !0
}), $(document).on("mouseleave", "#anchorMenu ", function() {
    mouse_in_asidemenu = !1, setTimeout(function() {
        close_sidebar(!1, "#anchorMenu")
    }, 3e3)
}), $(document).on("keydown", function(e) {
    27 == e.keyCode && $("aside").removeClass("visible")
}), $("#contentEditable").on("click", function(e) {
    e.preventDefault(), set_contentEditable ? (set_contentEditable = !1, $("aside").removeClass("visible"), $(this).addClass("active"), $($textTypes).addClass("cursor_pointer"), $("[contenteditable]").removeAttr("contenteditable"), toastr.info("Click on elements to format", "Design Mode enabled")) : (set_contentEditable = !0, $(this).removeClass("active"), $($textTypes).removeAttr("contenteditable"), $($textTypes).removeClass("cursor_pointer"), $(".property_sidebar").removeClass("visible"))
}), $(document).on("click", $textTypes, function(e) {
    e.preventDefault(), 0 == set_contentEditable ? ($("aside").removeClass("visible"), $(".property_sidebar").addClass("visible"), close_sidebar(!0, "#subMenu")) : ($(".focus_outline").removeClass("focus_outline"), $(this).attr("contenteditable", "true"), $(this).addClass("focus_outline"), set_contentEditable = !0)
});


$(document).on("click", ".position", function() {
   
    var d =$(this).data('side');
    $(".property_sidebar").hide();
    $("#"+d).show();
    $("#"+d).css("opacity","1");
  
});

var txt_available_options = ["background-color", "font-size", "letter-spacing", "font-style", "color", "text-transform", "text-align", "text-decoration", "font-weight"],
    xr, undo = [],
    temp, newK = $textTypes.replace(/ ,/g, "[style],");
$(document).on("keydown", function(e) {});
var undo_dump = "",
    cur_text_element2, cur_text_element = null,
    edf;
$(document).on("change", ".property", function() {
    var e = $(this).attr("name").toString();
    cur_text_element.css(e, $(this).val()), pushWork(cur_text_element, $(this).val())
});
var range_name, range_name_q;
$("input[type=range]").on("change", function() {
    range_name = $(this).attr("name").toString(), range_name_q = $(this).attr("data-target").toString()
}), $("input[type=range]").rangeslider({
    polyfill: !1,
    onSlideEnd: function(e, t) {
        var a = t.toString();
        a += "px", cur_text_element.css(range_name, a), $('#property [name="' + range_name_q + '"]').val(a), pushWork(cur_text_element, a)
    }
}), $("#apply_animation").click(function(e) {
    e.preventDefault(), cur_text_element.removeClass(animateClasses), e.preventDefault();
    var t = cur_text_element.attr("class");
    void 0 == cur_text_element.attr("data-animateeffect") || $("#currentanimation").text(": " + cur_text_element.attr("data-animateeffect"));
    var a = $(".js--animations").val();
    "clear" == a ? cur_text_element.removeClass("wow animated").removeAttr("data-animateeffect") : (cur_text_element.addClass(" animated " + a).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function() {
        $(this).removeClass(), $(this).addClass(" wow animated " + t + " "), $(this).attr("data-animateeffect", a)
    }), $("#currentanimation").text(": " + cur_text_element.attr("data-animateeffect")))
}), $(document).on("click", "#openanimation", function(e) {
    e.preventDefault(), $("aside").removeClass("visible"), $(".property_sidebar").addClass("visible"), $('#myTab a[href="#animation"]').tab("show"), $('#myTab a[href="#property"]').hide(), cur_text_element = singleElement, $("#current_edit").text("Animation")
}), $(".js--animations").change(function() {
    var e = $(this).val();
    testAnim(e)
}), $("#font").fontselect().change(function() {
    var e = $(this).val(),
        t = $(this).val().replace(/\+/g, " ");
    t = t.split(":"), cur_text_element.css("font-family", t[0]), cur_text_element.attr("data-font", e), cur_text_element.addClass("fontchange")
}), $(document).on("click", "#clearfontstyle", function(e) {
    e.preventDefault(), $(".fontchangers").empty(), toastr.info("Global Fonts are Reseted")
}), $(document).on("click", "#fireglobal", function(e) {
    globalfont()
}), $(document).on("click", $textTypes, function(e) {
    for (e.preventDefault(), $('#myTab a[href="#property"]').tab("show"), $('#myTab a[href="#property"]').show(), $("#current_edit").text(e.target.tagName), cur_text_element = $(e.target), $("#cur_font").text($(e.target).css("font-family").replace(", sans-serif", "")), $("#cur_font").css("font-family", $(e.target).css("font-family")), i = 0; i < txt_available_options.length; i++) {
        var t = $("#property [name='" + txt_available_options[i] + "']");
        if (t.removeClass("hidden"), 1 == t.is("input")) {
            var a = cur_text_element.css(t.attr("name").toString());
            t.val(a), color_picker()
        }
        if (1 == t.is("input[type=range]")) {
            var n, o, r;
            n = t, o = t.attr("name").toString(), r = $("input[data-target=" + o + "]");
            var s = n.filter("input[type=text]").val().toString().replace(/[^\d]/g, "");
            r.val(s).change()
        }
    }
}), $(document).on("mouseenter", $textTypes, ".omg_component div[class*='col-']:not(.masonry_item)", function() {
    $(this).addClass("outline")
}), $(document).on("focus", $textTypes, function() {
    $(this).addClass("focus_outline"), $("aside").removeClass("visible"), "&nbsp;" == $(this).html() && $(this).text("")
}), $(document).on("focusout", $textTypes, function() {
    $(this).removeClass("focus_outline")
}), $(document).on("mouseleave", $textTypes, function(e) {
    $(this).removeClass("outline")
});
var current_edit_color;
$(document).on("click", "#property .color", function(e) {}), $("#property .color").on("beforeShow.spectrum", function(e, t) {
    current_edit_color = $(this).attr("name")
}), $(document).on("mouseenter", ".omg_component", function(e) {
    ele = $(this), $(".badge_abs > div:last").removeClass("hidden");
    var t = ele.offset();
    if ($(".badge_abs").css("right", "85px"), $(".badge_abs").css("top", t.top + 45), $(".badge_abs").removeClass("hidden"), 0 != $(this).find(".overlay").length ? ($(".ov_change").removeClass("hidden"), background_color($(this).find(".overlay"), $(this).find(".overlay"), ".overlay_changer")) : $(".ov_change").addClass("hidden"), $(this).find(".bg-color").length > 0 ? ($(".bgcol_changer").removeClass("hidden"), background_color($(this).find(".bg-color"), $(this).find(".bg-color"), ".bgColor_changer")) : $(".bgcol_changer").addClass("hidden"), $(this).find(".hero_layout").length > 0 ? $(".hero_layout_changer").removeClass("hidden") : $(".hero_layout_changer").addClass("hidden"), $(this).find(".parallax-content").length > 0 ? $(".parallaxclasscont").removeClass("hidden") : $(".parallaxclasscont").addClass("hidden"), $(this).find(".instafeed").length > 0) {
        var a = $(this).find(".instafeed");
        targetinstacontrol = a, $(".widget_box.instacontrol").removeClass("hidden").css("top", a.offset().top + 10).css("left", a.offset().left + a.width() / 2), $(".widget_box.instacontrol a").attr("data-username-insta", targetinstacontrol.attr("data-insta-username"))
    } else $(".widget_box.instacontrol").addClass("hidden");
    $(this).find(".maps").length > 0 && (currentEditMap = $(this).find(".maps"), $("#latitude").val(currentEditMap.attr("data-latitude")), $("#longitude").val(currentEditMap.attr("data-longitude")), $(".widget_box.mapcontrol").removeClass("hidden").css("top", currentEditMap.offset().top + 10).css("left", currentEditMap.offset().left + currentEditMap.width() / 2)), $(this).find("form").length > 0 && (currentEditForm = $(this).find("form"), $(".formURL").val(currentEditForm.attr("action")), $("#SuccessMsg").val(currentEditForm.attr("data-success-msg")), $("#ErrorMsg").val(currentEditForm.attr("data-error-msg")), $(".widget_box.formeditor").removeClass("hidden").css("top", $(this).offset().top + 10).css("left", currentEditForm.offset().left + 10), currentEditForm.hasClass("mailchimp") && (console.log("mailchimp"), $(".mailchimpcontroller").removeClass("hidden"), $(".phpform").addClass("hidden")), currentEditForm.hasClass("phpmailform") && (console.log("phpmailform"), $(".phpform").removeClass("hidden"), $(".mailchimpcontroller").addClass("hidden")))
});
var cur_hero_layout;
$(document).on("click", "#updateMaps", function() {
    "" != $("#latitude").val() && (currentEditMap.attr("data-latitude", $("#latitude").val()).attr("data-longitude", $("#longitude").val()), loadMap(), $("#MapsEdit").modal("hide"))
}), $(document).on("mouseenter", ".hero_layout", function() {
    $(this).hasClass("hero_layout") ? ($(".hero_layout_changer").removeClass("hidden"), cur_hero_layout = $(this)) : $(".hero_layout_changer").addClass("hidden")
}), $(document).on("mouseenter", ".bg-img", function() {
    media_setup_for = "bg", background_image = $(this)
});
var cur_slideshow = null,
    cur_slideshow_slide = null;
$(document).on("click", "#openpagemenu", function(e) {
    e.preventDefault(), $("aside").removeClass("visible"), $("#pageMenu").addClass("visible")
});
var counter = 1;
$(document).on("click", "#addpage", function(e) {
    e.preventDefault();
    var t = prompt("Please enter your page name", "page" + counter);
    counter++, null != t && "" != t && ($("." + t).length > 0 && (t = t + "_0" + counter), $(".omg_page").removeClass("active_page"), flushwidget(), $(".omg_browser").append("<div class='omg_page pages active_page " + t + " 'data-pagename='" + t + "'></div>"), $(".page_list li").removeClass("active"), $("#currentpagename").text(t), $(".page_list").append("<li class='active'>  <i class='mdi-editor-insert-drive-file'></i> <a href='#' class='pages pgname " + t + " 'data-pagename='" + t + "'>  " + t + "</a><div class='pull-right'><a href='#'class='dropdown pages " + t + "'data-pagename='" + t + "' data-toggle='dropdown'><i class='mdi-navigation-more-vert i-24'></i></a><ul class='dropdown-menu dropdown-menu-scale pull-right pull-up grey-900'><li><a href='#' class='renamepage'><i class='mdi-content-text-format'></i> Rename</a></li><li><a href='#' class='sortelements'><i class='mdi-content-sort'></i> Rearrange Blocks</a></li><li><a href='#' class='deletepage'><i class='mdi-content-clear'></i> delete</a></li></ul> <a href='#' title='Copy the HTML page' class='quickref i-24 mdi-file-file-download'></a></div></li>"), toastr.info("Now Lets add Some Components to it", "Wow! <b>" + t + ".html</b> is Created"), $("aside").removeClass("visible"), $("#subMenu").addClass("visible"), document.title = document.projectName + " : " + t)
}), $(".navigation a").click(function() {
    e.preventDefault(), flushwidget()
}), $(document).on("click", ".pgname", function(e) {
    e.preventDefault(), flushwidget();
    var t = $(this).attr("data-pagename");
    $(".page_list li").removeClass("active"), $(this).parent().addClass("active"), $(".omg_page").removeClass("active_page"), $("." + t).addClass("active_page"), init_load(), document.title = document.projectName + " : " + t
}), $(document).on("click", ".renamepage", function(e) {
    e.preventDefault();
    var t = $(this).parent().parent().parent().children("a").attr("data-pagename"),
        a = prompt("enter the page name", t);
    null != a && "" != a && ($(".pages." + t).attr("data-pagename", a).addClass(a).removeClass(t), $(".page_list li a.pgname." + a).text(a), toastr.info("<b>" + t + "</b> is renamed to <b>" + a + "</b>"), document.title = document.projectName + " : " + a)
}), $(document).on("click", ".deletepage", function(e) {
    e.preventDefault();
    var t = $(this).parent().parent().parent().children("a").attr("data-pagename");
    1 == confirm("Do you want to really DELETE " + t + ".html ?") && ($(".page_list a." + t).parent().remove(), $(".omg_browser ." + t).remove(), $(".omg_browser > .omg_page:first").addClass("active_page"), $(".page_list > li:first").addClass("active"), flushwidget(), toastr.error(t + ".html is deleted"), document.title = document.projectName)
}), $(document).on("click", "#deleteBlock", function(e) {
    e.preventDefault(), 1 == confirm("Do you want to really DELETE this block ?") && ($(ele).remove(), flushwidget(), ele = null, toastr.error("Block deleted."), isEmpty(), $.stellar("refresh"))
}), $(document).on("click", "#cloneBlock", function(e) {
    e.preventDefault(), toastr.info("Block Copied."), $(".slideshow").slick();
    var t = ele.clone();
    ele.find(".slideshow").length > 0 && t.find(".slideshow").slick("unslick"), ele.after(t), $(".slideshow").slick(), init_load()
}), $(document).on("click", "#deleteAll", function(e) {
    e.preventDefault(), 1 == confirm("Do you want to really Clear All Blocks ?") && ($(".omg_page.active_page").empty(), flushwidget(), $("aside").removeClass("visible"), ele = null, toastr.info("Page Cleared"), isEmpty())
}), $("div[contenteditable=true]").keydown(function(e) {
    return 13 === e.keyCode ? (document.execCommand("insertHTML", !1, "<br><br>"), !1) : void 0
}), $(document).on("click", "#layout_manager a", function(e) {
    e.preventDefault(), $("#layout_manager a").removeClass("active"), $(this).addClass("active");
    var t = $(this).attr("data-class").toString();
    cur_hero_layout.find(".h-align").removeClass("v-middle v-top v-bottom h-left h-right h-center").addClass("h-align").addClass(t)
});
var firstTimeUnsplash = !0,
    firstlocalmedia = !0;
$('a[href="#medialibrary"]').on("shown.bs.tab", function(e) {
    1 == firstlocalmedia && ($("#medialibrary").load("local_media.php"), firstlocalmedia = !1)
}), $("#BgImage").on("show.bs.modal", function(e) {
    if (1 == firstTimeUnsplash) {
        for (i = total_unsplash_img; i > total_unsplash_img - no_img_page; i--) {
            var t = $('[data-template="image_modal"] .col-md-3').clone();
            t.find(".caption").addClass("selected_img unsplash"), t.find("a").attr("id", i), t.find("img").attr("src", "https://unsplash.it/458/354?image=" + i), bg_prepend.append(t), img_remain = total_unsplash_img - no_img_page
        }
        firstTimeUnsplash = !1
    }
}), $("#bg_prepend").scroll(function() {
    if ($(this)[0].scrollHeight - $(this).scrollTop() == $(this).outerHeight()) {
        for (i = img_remain; i > img_remain - no_img_page; i--) {
            var e = $('[data-template="image_modal"] .col-md-3').clone();
            e.find("a").attr("id", i), e.find(".caption").addClass("selected_img unsplash"), e.find("img").attr("src", "https://unsplash.it/458/354?image=" + i), bg_prepend.append(e)
        }
        img_remain > 0 && (img_remain -= no_img_page)
    }
});
var cur_img, dummy_ele;
$(document).on("click", "#updateImg", function(e) {
    e.preventDefault();
    var t = $(this).attr("imgurl");
    "bg" == media_setup_for && (dummy_ele = background_image, background_image.css("background-image", "url('" + t + "')")), "img" == media_setup_for && cur_img.attr("src", t), toastr.success("right click on image for more options", "image updated."), $("#BgImage").modal("hide")
}), $(document).on("click", ".undoImg", function(e) {
    e.preventDefault(), $(".selected_img_border").removeClass("selected_img_border")
}), $(document).on("click", ".selected_img", function(e) {
    e.preventDefault(), $("#BgImage .selected_img_border").removeClass("selected_img_border"), $(this).addClass("selected_img_border");
    var t;
    if ($(this).hasClass("unsplash")) {
        var a = $(this).attr("id");
        t = "https://unsplash.it/" + image_resolution_for_unsplash + "?image=" + a
    } else t = $(this).find("img").attr("src");
    $("#updateImg").attr("imgUrl", t)
}), Dropzone.options.myAwesomeDropzone = {
    init: function() {
        this.on("success", function(e, t) {
            $("#medialibrary").load("local_media.php"), $(' a[href="#medialibrary"]').tab("show"), $("div.dz-success").remove()
        })
    }
}, $(document).click(function(e) {
    $("#contextmenu").removeClass("open"), $("div.outline").removeClass("outline")
}), $(document).on("mouseleave", ".omg_component div[class*='col-']", function() {
    $(this).removeClass("outline")
}), $(document).on("mouseenter", ".omg_component div[class*='col-']", function() {
    $(this).addClass("outline")
});
var singleElement;
$(document).on("contextmenu", $textTypes + ", .omg_component div[class*='col-']:not(.masonry_item) , .omg_component img ,.omg_component a ,.omg_component .icon ,.omg_component .open_video , .omg_component .slide, .omg_component .bg-img ", function(e) {
    fake_var = e, 0 == $(e.target).parents(".instafeed").length && ($("#contextmenu li:not(.leaveit)").addClass("hidden"), $("#contextmenu").removeClass("open"), ("A" == e.target.tagName || "IMG" == e.target.tagName || 1 == $(e.target).closest("img").length || 1 == $(e.target).closest(".bg-img").length || "A" == e.target.parentNode.tagName || $(e.target).hasClass("icon") || $(e.target).parents(".slideshow").length > 0) && (("A" == e.target.parentNode.tagName || "A" == e.target.tagName) && (singleElement = $(e.target), $("#tagname").text("Anchor"), $("#openanchormodal").parent().removeClass("hidden")), $(e.target).hasClass("icon") && (singleElement = $(e.target), $("#tagname").text("icon"), $("#Changeicon").parent().removeClass("hidden")), "IMG" == e.target.tagName && (singleElement = $(e.target), $("#tagname").text("Image"), $("#contextmenu .change_image_preview").attr("src", $(e.target).attr("src")), $("#contextmenu .openimgmodal").parent().removeClass("hidden")), 1 == $(e.target).closest("img").length && ($("#tagname").text("Image"), $("#contextmenu .change_image_preview").attr("src", $(e.target).attr("src")), singleElement = $(e.target).closest("img"), $("#contextmenu .openimgmodal").parent().removeClass("hidden")), 1 == $(e.target).closest(".bg-img").length && ($("#tagname").text("BgImage"), ("none" != $(e.target).closest(".bg-img").css("background-image") || void 0 != $(e.target).closest(".bg-img").css("background-image")) && (fake_var = $("#contextmenu .change_bgimage").css("background-image", $(e.target).closest(".bg-img").css("background-image"))), singleElement = $(e.target).closest(".bg-img"), $("#contextmenu .openbgimgmodal").parent().removeClass("hidden")), $(e.target).hasClass("open_video") && ($("#tagname").text("Video "), singleElement = $(e.target), $("#openanchormodal").parent().removeClass("hidden"), targetAnchor = e.target), 0 != $(e.target).parents(".navbar").length && $("#deleteNav").parent().removeClass("hidden"), $(e.target).parents(".slideshow").length > 0 && ($("#tagname").text("slideshow"), singleElement = $(e.target), $("#addSlide").parent().removeClass("hidden"), $("#removeSlide").parent().removeClass("hidden"), cur_slideshow = $(e.target).parents(".slideshow"), cur_slideshow_slide = $(e.target).closest(".slide"), $("#tagname").text("slideshow"))), 0 == $(e.target).parents(".slideshow").length && ($("#contextmenu li.leaveit").removeClass("hidden"), singleElement = $(e.target)), RightContextMenu(e))
}), $(document).on("click", "#addSlide", function(e) {
    e.preventDefault(), cur_slideshow.slick("slickAdd", cur_slideshow_slide.clone()), parallaxclass && (null != parallaxclass.attr("data-stellar-background-ratio") ? (parallaxclass.parents(".slideshow").find(".parallax-content").removeAttr("data-stellar-background-ratio"), parallaxclass.parents(".slideshow").find(".parallax-content").css("background-position", "0px 0px"), parallaxclass.parents(".slideshow").find(".parallax-content").attr("data-stellar-background-ratio", "0.5"), $.stellar("refresh")) : $.stellar("refresh")), toastr.info("Slide Cloned.")
}), $(document).on("click", "#removeSlide", function(e) {
    if (e.preventDefault(), confirm("Sure you want delete the Current Slide?")) {
        var t = cur_slideshow.slick("slickCurrentSlide");
        cur_slideshow.slick("slickRemove", t), toastr.error("Slide Deleted.")
    }
}), $(document).on("click", "#Changeicon", function(e) {
    $("#icons").modal(), e.preventDefault()
}), $(document).on("click", "#openanchormodal", function(e) {
    e.preventDefault(), $("#newTab").prop("checked", !1), $("#urlInput").val("http://"), $("aside").removeClass("visible");
    var t = targetAnchor.attr("href");
    if ($("#urlInput").val(t), "_blank" == targetAnchor.attr("target") && $("#newTab").prop("checked", !0), $("#anchorMenu").addClass("visible"), targetAnchor.hasClass("open_video")) {
        $("#apply_url").addClass("hidden"), $("#apply_video_url").removeClass("hidden"), $(".newTab").addClass("hidden"), $("#previewVideo").removeClass("hidden"), $("#apply_video_url").attr("data-target", "lighbox");
        var a = targetAnchor.find("[data-src]").attr("data-src");
        $("#urlInput").val(a), $("#previewVideo").attr("src", a)
    } else e.preventDefault(), $("#apply_url").removeClass("hidden"), $("#apply_video_url").addClass("hidden"), $(".newTab").removeClass("hidden"), $("#previewVideo").addClass("hidden")
}), $(document).on("click", "#inlineVideo", function(e) {
    e.preventDefault(), $("#anchorMenu").addClass("visible"), $("#apply_url").addClass("hidden"), $("#apply_video_url").removeClass("hidden"), $(".newTab").addClass("hidden"), $("#previewVideo").removeClass("hidden"), $("#apply_video_url").attr("data-target", "iframe");
    var t = targetVideoIframe.attr("src");
    $("#urlInput").val(t), $("#previewVideo").attr("src", t)
}), $(document).on("click", "#apply_video_url", function(e) {
    e.preventDefault(), "lighbox" == $(this).attr("data-target") && targetAnchor.find("[data-src]").attr("data-src", $("#urlInput").val()), "iframe" == $(this).attr("data-target") && targetVideoIframe.attr("src", $("#urlInput").val()), $("#anchorMenu").removeClass("visible"), $("#previewVideo").removeAttr("src"), init_lightBox(), toastr.success("<a href=" + $("#urlInput").val().toString() + ' class="open_toast" target="_blank">Click here to open', "Anchor Tag Updated</a>")
}), $(document).on("click", "#apply_url", function(e) {
    e.preventDefault(), targetAnchor.attr("href", $("#urlInput").val().toString()), $("#newTab").is(":checked") ? targetAnchor.attr("target", "_blank") : targetAnchor.removeAttr("target"), toastr.success("<a href=" + $("#urlInput").val().toString() + ' class="open_toast" target="_blank">Click here to open', "Anchor Tag Updated</a>"), $("#anchorMenu").removeClass("visible")
}), $(document).on("click", ".openimgmodal", function(e) {
    e.preventDefault(), media_setup_for = "img", $("#BgImage").modal("show")
}), $(document).on("click", ".openbgimgmodal", function(e) {
    e.preventDefault(), $("#BgImage").modal("show"), media_setup_for = "bg"
}), $(document).on("click", "#deleteelement", function(e) {
    e.preventDefault(), confirm("Are you sure delete the element ?") && (0 != singleElement.parents(".navbar").length ? singleElement.is("a") && singleElement.parents("li").remove() : singleElement.remove(), toastr.error("Element deleted."))
}), $(document).on("click", "#deleteNav", function(e) {
    e.preventDefault(), confirm("Are you sure delete the Navigation bar ?") && 0 != singleElement.parents(".navbar").length && singleElement.parents(".navbar").remove()
}), $(document).on("click", "#copyelement", function(e) {
    if (e.preventDefault(), 0 != singleElement.parents(".navbar").length) {
        if (singleElement.is("a")) {
            var t = singleElement.parents("li").clone();
            singleElement.parents("li").after(t)
        }
    } else {
        var a = singleElement.clone();
        singleElement.after(a)
    }
    toastr.info("Element Cloned.")
}), $(document).on("click", ".omg-asideclose", function(e) {
    e.preventDefault()
}), $(document).on("mouseenter", ".parallax-content", function() {
    $(".parallaxclasscont").removeClass("hidden"), parallaxclass = $(this), null != parallaxclass.attr("data-stellar-background-ratio") ? $("#parallaxSwitch").prop("checked", !0) : $("#parallaxSwitch").prop("checked", !1)
}), $(document).on("click", "#parallaxSwitch", function(e) {
    1 == $(this).prop("checked") && (parallaxclass.attr("data-stellar-background-ratio", "0.5"), parallaxclass.parents(".slideshow") && parallaxclass.parents(".slideshow").find(".parallax-content").attr("data-stellar-background-ratio", "0.5"), $.stellar("refresh")), 0 == $(this).prop("checked") && (parallaxclass.removeAttr("data-stellar-background-ratio"), parallaxclass.parents(".slideshow") && parallaxclass.parents(".slideshow").find(".parallax-content").removeAttr("data-stellar-background-ratio"), $.stellar("refresh"))
}), $(document).on("click", ".sortelements", function(e) {
    e.preventDefault(), sortBegin = !0, $("html, body").animate({
        scrollTop: 0
    }, "slow"), $("body").addClass("disable"), $(".active_page").sortable({
        scroll: !1
    }), $(".cntrl-nav").hide(), $(".reorder_nav").removeClass("hidden"), innerSortable(), innerSortable("destroy"), init_parallax("destroy")
}), $(document).on("click", ".cancelsort", function(e) {
    e.preventDefault(), sortBegin = !1, flushwidget(), $("body").removeClass("disable"), $(".active_page").sortable("destroy"), $("aside").removeClass("visible"), $(".reorder_nav").addClass("hidden"), $(".cntrl-nav").show(), innerSortable(), init_load(), setTimeout(function() {
        $.stellar("refresh")
    }, 800)
}), toastr.options = {
    closeButton: !0,
    debug: !1,
    newestOnTop: !1,
    progressBar: !1,
    positionClass: "toast-bottom-right",
    preventDuplicates: !1,
    onclick: null,
    timeOut: "2500",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut"
}, loadStyleSheet();
var customStyleArray = [],
    customStyle = "";
$(document).on("click", "#opendownloadmenu", function(e) {
    $("aside").removeClass("visible"), $("#downloadMenu").addClass("visible"), e.preventDefault()
}), $("#export").click(function(e) {
    e.preventDefault(), customStyleArray = [], customStyle = "", $("#customstyle").val(""), 0 == $(".omg_browser .omg_page .omg_component").length ? toastr.error("Please Add Components to Pages before Export", "Error") : ($(this).find(".progress-inner").addClass("inprogress"), $(this).attr("disable", "true"), $(this).css("cursor", "wait"), $(".mainnav a").attr("disable"), setTimeout(function() {
        toastr.info("File Exported", "File Export Disabled for online demo"), $("#export").find(".progress-inner").removeClass("inprogress"), $("#export").removeAttr("disable"), $("#export").css("cursor", "pointer"), innerSortable()
    }, 5500))
}), $(document).on("click", ".forceStop", function(e) {
    e.stopPropagation()
}), $(document).on("click", ".quickref", function(e) {
    e.preventDefault(), toastr.info("Export Disabled for online Demo")
});
var cur_masonaryItem;
$(document).on("mouseenter", ".masonry_item", function(e) {
    cur_masonaryItem = $(this), $("#masonry_widget").removeClass("hidden").css("top", $(this).offset().top + 10).css("left", $(this).offset().left + $(this).width() / 2 - 40)
}), $(document).on("click", "#masonryClone", function(e) {
    e.preventDefault();
    var t = cur_masonaryItem.clone();
    cur_masonaryItem.parents(".masonry-container").append(t).masonry("appended", t), toastr.info("Portfolio Item copied & appended to bottom.")
}), $(document).on("click", "#masonryDelete", function(e) {
    e.preventDefault(), confirm("Are you sure you want to delete this item?") && (cur_masonaryItem.parents(".masonry-container").masonry("remove", cur_masonaryItem).masonry("layout"), toastr.error("Portfolio Item deleted."), flushwidget())
}), $(document).on("click", "#masonryImage", function(e) {
    e.preventDefault(), media_setup_for = "img", cur_img = cur_masonaryItem.find("img"), $("#BgImage").modal("show")
}), $("#BgImage").on("hidden.bs.modal", function(e) {
    $(".masonry-container").imagesLoaded(function() {
        setTimeout(function() {
            void 0 != cur_masonaryItem && cur_masonaryItem.parents(".masonry-container").masonry()
        }, 150)
    })
});
var project_menu = "pagelist.list",
    projects_pages = "pages.data";
$("#openproject").on("click", function(e) {
    $("#file").trigger("click")
}), $("#file").on("change", function(e) {
    for (var t, a = e.target.files, n = 0; t = a[n]; n++) {
        var o = new FileReader;
        o.onload = function(e) {
            return function(e) {
                try {
                    var t = new JSZip(e.target.result);
                    $.each(t.files, function(e, t) {
                        
                        t.name == projects_pages && ($(".omg_browser").empty(), $("#htmlsanit").empty(), $(".omg_browser").append(t.asText()), $(".omg_page").css("display", "block"), $(".omg_page").css("visibility", "hidden"), init_load(), $(".omg_page").css("display", ""), $(".omg_page").css("visibility", ""), isEmpty(), init_insta()), t.name == project_menu && ($(".page_list").empty(), $(".page_list").append(t.asText()))
                    })
                } catch (e) {
                    alert("invalid project file!!")
                }
            }
        }(t), o.readAsArrayBuffer(t)
    }
}), $(".mainnav [title]").tooltip({
    placement: "right"
}), "file:" == window.location.protocol && (alert("You need to run this on local server read DOCS for information"), setTimeout(function() {
    toastr.info("Please read docs for information", "Hint: use builder on localserver like WAMP or XAMP Etc"), toastr.error("You cannot run this on file:// to use builder you need start this on local server", "503:Builder Loading Failed"), toastr.error("Cannot load modules", "485:Critcal error")
}, 600)), Ps.initialize(document.getElementById("componentdrawer")), Ps.initialize(document.getElementById("dsr")), $("#openDemo , #closedemo").click(function() {
    demoMenu()
}), $(document).on("click", "#openFormMenu", function(e) {
    e.preventDefault(), $("#FormMenu").addClass("visible")
}), $(document).on("click", "#saveform", function(e) {
    e.preventDefault(), currentEditForm.hasClass("phpmailform") && (currentEditForm.attr("data-success-msg", $("#SuccessMsg").val()), currentEditForm.attr("data-error-msg", $("#ErrorMsg").val()), currentEditForm.attr("action", $(".phpmailform .formURL").val()), toastr.info("Form settings updated successFully"), $("aside").removeClass("visible")), currentEditForm.hasClass("mailchimp") && (currentEditForm.attr("action", $(".MailChimpURL").val()), toastr.info("Form settings updated successFully"), $("aside").removeClass("visible"))
});

$(".property_sidebar").addClass("visible"); 