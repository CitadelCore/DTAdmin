$(function() {

    Morris.Area({
        element: 'morris-area-chart',
        data: [{
            period: '2015 Q1',
            users: 10,
            vipusers: 5,
            admins: 3
        }, {
            period: '2015 Q2',
            users: 25,
            vipusers: 7,
            admins: 8
        }, {
            period: '2015 Q3',
            users: 32,
            vipusers: 10,
            admins: 11
        }, {
            period: '2015 Q4',
            users: 40,
            vipusers: 15,
            admins: 17
        }, {
            period: '2016 Q1',
            users: 75,
            vipusers: 25,
            admins: 22
        }, {
            period: '2016 Q2',
            users: 100,
            vipusers: 30,
            admins: 25
        }, {
            period: '2016 Q3',
            users: 150,
            vipusers: 60,
            admins: 27
        }, {
            period: '2016 Q4',
            users: 250,
            vipusers: 75,
            admins: 40
        }, {
            period: '2017 Q1',
            users: 350,
            vipusers: 90,
            admins: 55
        }, {
            period: '2017 Q2',
            users: 325,
            vipusers: 95,
            admins: 65
        }, {
            period: '2017 Q3',
            users: 311,
            vipusers: 96,
            admins: 63
        }],
        xkey: 'period',
        ykeys: ['users', 'vipusers', 'admins'],
        labels: ['Users', 'VIP Users', 'Staff'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Download Sales",
            value: 12
        }, {
            label: "In-Store Sales",
            value: 30
        }, {
            label: "Mail-Order Sales",
            value: 20
        }],
        resize: true
    });

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 90
        }, {
            y: '2007',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2010',
            a: 50,
            b: 40
        }, {
            y: '2011',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });

});
