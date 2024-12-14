
// market value chart
var options1 = {
    chart: {
        height: 380,
        type: 'radar',
        toolbar: {
            show: false
        },
    },
    series: [{
        name: 'Market value',
        data: [20, 100, 40, 30, 50, 80, 33],
    }],
    stroke: {
        width: 3,
        curve: 'smooth',
    },
    labels: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
    plotOptions: {
        radar: {
            size: 140,
            polygons: {
                fill: {
                    colors: ['#fcf8ff', '#f7eeff']
                },
                
            }
        }
    },
    colors: [ "#64C5B1" ],
    
    markers: {
        size: 6,
        colors: ['#fff'],
        strokeColor: "#64C5B1",
        strokeWidth: 3,
    },
    tooltip: {
        y: {
            formatter: function(val) {
                return val
            }   
        }
    },
    yaxis: {
        tickAmount: 7,
        labels: {
            formatter: function(val, i) {
                if(i % 2 === 0) {
                    return val
                } else {
                    return ''
                }
            }
        }
    }
}

var chart1 = new ApexCharts(
    document.querySelector("#marketchart"),
    options1
);

chart1.render();

// currently sale
var options = {
    series: [{
        name: 'series1',
        data: [0, 20, 15, 40, 18, 20, 18, 23, 18, 35, 30, 55, 0]
    }, {
        name: 'series2',
        data: [0, 22, 35, 32, 40, 25, 50, 38, 42, 28, 20, 45, 0]
    }],
    chart: {
        height: 90,
        type: 'area',
        toolbar: {
            show: false
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth'
    },
    xaxis: {
        type: 'category',
        low: 0,
        offsetX: 0,
        offsetY: 0,
        show: false,
        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Jan"],
        labels: {
            low: 0,
            offsetX: 0,
            show: false,
        },
        axisBorder: {
            low: 0,
            offsetX: 0,
            show: false,
        },
    },
    markers: {
        strokeWidth: 3,
        colors: "#ffffff",
        strokeColors: [ '#64C5B1', '#D6FFF9'],
        hover: {
            size: 6,
        }
    },
    yaxis: {
        low: 0,
        offsetX: 0,
        offsetY: 0,
        show: false,
        labels: {
            low: 0,
            offsetX: 0,
            show: false,
        },
        axisBorder: {
            low: 0,
            offsetX: 0,
            show: false,
        },
    },
    grid: {
        show: false,
        padding: {
            left: 0,
            right: 0,
            bottom: 0,
            top: 0
        }
    },
    colors: [ '#64C5B1', '#D6FFF9'],
    fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.5,
            stops: [0, 80, 100]
        }
    },
    legend: {
        show: false,
    },
    tooltip: {
        x: {
            format: 'MM'
        },
    },
};

var chart = new ApexCharts(document.querySelector("#chart-currently"), options);
chart.render();
