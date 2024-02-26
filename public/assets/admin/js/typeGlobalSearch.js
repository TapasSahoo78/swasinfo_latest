function readTextFile(file, callback) {
    var rawFile = new XMLHttpRequest();
    rawFile.overrideMimeType("application/json");
    rawFile.open("GET", file, true);
    rawFile.onreadystatechange = function () {
        if (rawFile.readyState === 4 && rawFile.status == "200") {
            callback(rawFile.responseText);
        }
    }
    rawFile.send(null);
}

function productsfilter() {

    $.ajax({
        type: "get",
        url: baseUrl + 'ajax/autocomplete',
        data: { user_id },
        cache: false,
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            data = response.data;
            console.log(data);
        },
        error: function (response) {
        }
        /* ,
        complete: function(response){
            location.reload();
        } */
    });

    // $.ajax({
    //     type: "GET",
    //     data: { user_id: user_id },
    //     url: baseUrl + 'ajax/autocomplete',
    //     dataType: "json",
    //     success: function (response) {
    //         data = response.data;
    //         console.log(data);
    //     }
    // });
};

$(document).ready(function () {
    productsfilter();
    productsdataRefresh();

    var substringMatcher = function (strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;
            matches = [];
            substrRegex = new RegExp(q, 'i');
            $.each(strs, function (i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });
            cb(matches);
        };
    };

});

function productsdataRefresh() {
    setTimeout(() => {
        $('#user_id').typeahead('destroy');
        products = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: data
        });
        products.initialize(),
            $('#user_id').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                name: 'products',
                display: 'name',
                source: products.ttAdapter(),
                templates: {
                    empty: [
                        '<div class="empty-message">',
                        'No Record Found !',
                        '</div>'
                    ].join('\n'),
                    suggestion: function (data) {
                        return '<a href="' + data.url + '" class="man-section"><div class="image-section"><img class="cateshortimg" src=' + data.picture + '></div><div class="description-section"><h4>' + data.name + '</h4></div></a>';
                    }
                },
            });
    }, 500);
};
