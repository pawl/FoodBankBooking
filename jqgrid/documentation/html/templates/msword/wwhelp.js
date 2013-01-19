/// <reference path="jquery.min.js" />
function SeeAlsoButton() {
    var SeeAlso = document.getElementById("See");
    if (SeeAlso.style.display == "none")
        SeeAlso.style.display = "";
    else
        SeeAlso.style.display = "none";
}
function AlwaysExpand(topicId) {    
    $("#" + topicId + "_span").show();
    $("#IMG" + topicId).attr("src", "bmp/minus.gif");
}
function Expand(topicId) {    
    $("#" + topicId + "_span").toggle();

    node = $("#IMG" + topicId).get(0);
    if (node != null) {
        if (node.src.indexOf("plus.gif") > -1)
            node.src = "bmp/minus.gif";
        else
            node.src = "bmp/plus.gif";
    }
}
function expandParents(id) {
    var $node = $("#" + id + "_span,#" + id);
    if ($node.length < 1)
        return;
    
    AlwaysExpand(id);

    var node = $node.get(0);

    var original = node;

    while (node != null) {
        node = node.parentNode;

        if (node == null)
            break;

        id = node.id;

        if (id == null || id == "")
            break;

        if (id.substr(0, 1) == "_")
            expandParents(id.replace("_span", ""));
    }

    original.scrollIntoView(true);
    window.scrollBy(-200, 0);
}
function findIdByTopic(topic) {
    if (!topic) {
        var query = window.location.search;
        var match = query.search("topic=");
        if (match < 0)
            return null;
        topic = query.substr(match + 6);
        topic = decodeURIComponent(topic);
    }
    var id = null;
    $("a").each(function () {        
        if ($(this).text().toLowerCase() == topic.toLocaleLowerCase()) {
            id = this.id;
            return;
        }
    });
    return id;
}
function indexPageLoad() {
    Expand('indexpage');

    // *** Expand all parent topics if an ID was passed
    var query = window.location.search;

    var match = query.search("page=");
    if (match > -1) {
        var page = query.substr(match + 5);
        expandParents(page);
        return;
    }

    match = query.search("topic=");
    if (match > -1) {
        var id = findIdByTopic();
        if (id) {
            var link = document.getElementById(id);
            var id = link.id;
            Expand(id);
            expandParents(id);

            if (window.parent && window.parent["wwhelp_right"])
                window.parent.frames["wwhelp_right"].location.href = id + ".htm";
        }
    }
}
function mtoParts(address,domain,query) {
    var url = "ma" + "ilto" + ":" + address + "@" + domain;
    if (query)
       url = url + "?" + query;
    return url;
}

$.fn.codeExampleTabs = function (options) {
    if (this.length == 0)
        return this;

    opt = { tabClass: "tabbutton",
        tabSelectedClass: "tabbutton-selected",
        onClick: null
    };
    $.extend(opt, options);
    $orig = this;

    var $theader = $("<div id='" + this.get(0).id + "_codetabs'>");

    var $tabcontainers = this.find(">.codeexample");
    if (($tabcontainers).length < 1)
       $tabcontainers = this.find("~.codeexample");
       if (($tabcontainers).length < 1)
          return this;
           
    $tabcontainers.eq(0).before($theader);

    $tabcontainers.each(function (i) {
        var $el = $(this);
        var $header = $(this).find(".codeexampleheader");
        if ($header.length == 0)
           return this;         
        var lang = $header.text();
                      
        if (!lang || lang == "")
           lang = "Code";

        var x = $("<div>").addClass(opt.tabClass)
                          .text(lang)
                          .click(function () {   
                              if ($(this).hasClass(opt.tabSelectedClass) )                                 
                                 return;

                              $tabcontainers.hide();
                              $theader.find("." + opt.tabSelectedClass).removeClass(opt.tabSelectedClass).addClass(opt.tabClass);
                              $(this).addClass(opt.tabSelectedClass).removeClass(opt.tabClass);
                              $el.show();
                          });
        if (i == 0) {
            $el.show();
            x.addClass(opt.tabSelectedClass).removeClass(opt.tabClass);
        }
        else {
            $el.hide();
            x.removeClass(opt.tabSelectedClass);
        }
        $el.css("margin-left",0).css("border-top-left-radius",0);

        $header.remove();

        $theader.append(x);
    });

    $theader.after("<br style='clear:both' />");
    return this;
};