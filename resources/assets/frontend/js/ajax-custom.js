var baseUrl = APP_URL + '/';
var data = '';
var customers = '';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function customersFilter() {
    findCustomers().done(function (response) {
        data = response;
        console.table(data);
    });
};
function customersdataRefresh() {
    setTimeout(() => {
        $('.typeahead').typeahead('destroy');
        customers = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: data
        });
        customers.initialize(),
            $('.typeahead').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            },
            {
                name: 'customers',
                display: 'name',
                source: customers.ttAdapter(),
                templates: {
                    empty: [
                        '<div class="empty-message">',
                        'No Record Found !',
                        '</div>'
                    ].join('\n'),
                    suggestion: function (data) {
                        console.log(data);
                        return '<a href="' + '#' + '" class="man-section"><div class="description-section"><h4>' + data.name + '</h4><span>' + data.aadhaar_no + '</span></div><div><h4>' + data.loan_amount + '</h4></div></a>';
                    }
                },
            });
    }
        , 1500);
};
$(document).ready(function () {
    customersFilter();
    customersdataRefresh();
    $('#user_id').on('keydown', function () {
        customersFilter();
        customersdataRefresh();
    });
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



function findCustomers() {
    return $.ajax({
        type: "get",
        data: { user_id: $('#user_id').val() },
        url: baseUrl + 'ajax/autocomplete',
        dataType: "json",
    });

}
