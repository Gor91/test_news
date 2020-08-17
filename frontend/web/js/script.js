'use strict';

function getNews(cat_id) {
    $.get(window.location.origin + "/v1/news/category/" + cat_id + "?access-token=" + $("#_access_token").val(), function (data, status) {
        let items = '';
        let loading = $('#loader-background');

        loading.show();

        if (data && data.length) {
            for (let i in data) {
                let cat_list = data[i].categoriesList;
                items += "<div class='col-lg-4'>";
                items += "<h2>" + data[i].title + "</h2>";
                items += "<p>" + data[i].content + "</p>";
                items += "<i>Categories: ";
                for (let c in cat_list) {
                    if (c > 0) {
                        items += ', ' + cat_list[c].title;
                    } else {
                        items += cat_list[c].title;
                    }
                }
                items += "</i>";
                items += "</div>";
            }
        } else {
            items = "No result";
        }

        loading.hide();
        $('#news_items').html(items);
    });
}