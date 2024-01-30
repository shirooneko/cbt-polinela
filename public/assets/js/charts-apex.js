/**
 * Charts Apex
 */

"use strict";

(function () {
  let cardColor, headingColor, labelColor, borderColor, legendColor;

  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    headingColor = config.colors_dark.headingColor;
    labelColor = config.colors_dark.textMuted;
    legendColor = config.colors_dark.bodyColor;
    borderColor = config.colors_dark.borderColor;
  } else {
    cardColor = config.colors.cardColor;
    headingColor = config.colors.headingColor;
    labelColor = config.colors.textMuted;
    legendColor = config.colors.bodyColor;
    borderColor = config.colors.borderColor;
  }

  // Color constant
  const chartColors = {
    column: {
      series1: "#826af9",
      series2: "#d2b0ff",
      bg: "#f8d3ff",
    },
    donut: {
      series1: "#fdd835",
      series2: "#32baff",
      series3: "#ffa1a1",
      series4: "#7367f0",
      series5: "#29dac7",
      series6: "#7743DB",
      series7: "#99B080",
      series8: "#1F4172",
    },
    area: {
      series1: "#ab7efd",
      series2: "#b992fe",
      series3: "#e0cffe",
    },
  };

  const chartElementSelectorSex = "#radialBarChartSex";

  const apiEndpointSex = "/admin/getChartDataSex";

  fetch(apiEndpointSex)
    .then((response) => response.json())
    .then((chartData) => {
      // Menggabungkan pengaturan warna dan gaya yang sudah ada
      const chartConfig = {
        chart: {
          height: 380,
          fontFamily: "Inter",
          type: "radialBar",
        },
        colors: [
          chartColors.donut.series1,
          chartColors.donut.series2,
          chartColors.donut.series4,
        ],
        plotOptions: {
          radialBar: {
            size: 185,
            hollow: {
              size: "40%",
            },
            track: {
              margin: 10,
              background: config.colors_label.secondary,
            },
            dataLabels: {
              name: {
                fontSize: "2rem",
              },
              value: {
                fontSize: "1.2rem",
                color: legendColor, // Menggunakan warna dari variabel yang sudah ditentukan
              },
              total: {
                show: true,
                fontWeight: 400,
                fontSize: "1.125rem",
                color: headingColor, // Menggunakan warna dari variabel yang sudah ditentukan
                label: "Mahasiswa",
                formatter: function (w) {
                  return "100%";
                },
              },
            },
          },
        },
        grid: {
          borderColor: borderColor, // Menggunakan warna dari variabel yang sudah ditentukan
          padding: {
            top: -35,
            bottom: -30,
          },
        },
        legend: {
          show: true,
          position: "bottom",
          labels: {
            colors: legendColor, // Menggunakan warna dari variabel yang sudah ditentukan
            useSeriesColors: false,
          },
        },
        stroke: {
          lineCap: "round",
        },
        series: chartData.map((item) => item.percentage),
        labels: chartData.map((item) => item.sex),
      };

      // Render Chart
      const chartElement = document.querySelector(chartElementSelectorSex);
      if (typeof chartElement !== "undefined" && chartElement !== null) {
        const chart = new ApexCharts(chartElement, chartConfig);
        chart.render();
      }
    })
    .catch((error) => console.error("Error fetching chart data:", error));

  // Selector untuk elemen chart Prodi
  const chartElementSelector = "#donutChart";
  // Endpoint API untuk data Prodi
  const apiEndpoint = "/admin/getChartDataProdi";

  // Mengambil data dari API dan membuat chart
  fetch(apiEndpoint)
    .then((response) => response.json())
    .then((chartData) => {
      // Mengolah data yang didapat dari API
      const labels = chartData.map((item) => item.prodi); // Ganti 'prodi' dengan properti yang sesuai dari data Anda
      const series = chartData.map((item) => item.percentage); // Ganti 'percentage' dengan properti yang sesuai dari data Anda

      // Konfigurasi Donut Chart
      const donutChartConfig = {
        chart: {
          height: 390,
          fontFamily: "Inter",
          type: "donut",
        },
        labels: labels,
        series: series,
        colors: [
          chartColors.donut.series1,
          chartColors.donut.series2,
          chartColors.donut.series3,
          chartColors.donut.series4,
          chartColors.donut.series5,
          chartColors.donut.series6,
          chartColors.donut.series7,
          chartColors.donut.series8,
        ],
        stroke: {
          show: false,
          curve: "straight",
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return parseInt(val, 10) + "%";
          },
        },
        legend: {
          show: true,
          position: "bottom",
          markers: {
            offsetX: -3,
          },
          itemMargin: {
            vertical: 3,
            horizontal: 10,
          },
          labels: {
            colors: legendColor,
            useSeriesColors: false,
          },
        },
        plotOptions: {
          pie: {
            donut: {
              labels: {
                show: true,
                name: {
                  fontSize: "2rem",
                },
                value: {
                  fontSize: "1.5rem",
                  color: legendColor,
                  formatter: function (val) {
                    return parseInt(val, 10) + "%";
                  },
                },
                total: {
                  show: true,
                  fontSize: "0.8rem",
                  color: headingColor,
                  label: "Mahasiswa",
                  formatter: function (w) {
                    return "100%";
                  },
                },
              },
            },
          },
        },
        responsive: [
          {
            breakpoint: 992,
            options: {
              chart: {
                height: 380,
              },
              legend: {
                position: "bottom",
                labels: {
                  colors: legendColor,
                  useSeriesColors: false,
                },
              },
            },
          },
          {
            breakpoint: 576,
            options: {
              chart: {
                height: 320,
              },
              plotOptions: {
                pie: {
                  donut: {
                    labels: {
                      show: true,
                      name: {
                        fontSize: "1.5rem",
                      },
                      value: {
                        fontSize: "1rem",
                      },
                      total: {
                        fontSize: "1.5rem",
                      },
                    },
                  },
                },
              },
              legend: {
                position: "bottom",
                labels: {
                  colors: legendColor,
                  useSeriesColors: false,
                },
              },
            },
          },
          {
            breakpoint: 420,
            options: {
              chart: {
                height: 280,
              },
              legend: {
                show: false,
              },
            },
          },
          {
            breakpoint: 360,
            options: {
              chart: {
                height: 250,
              },
              legend: {
                show: false,
              },
            },
          },
        ],
      };

      // Membuat dan merender Donut Chart
      const chartElement = document.querySelector(chartElementSelector);
      if (chartElement) {
        const donutChart = new ApexCharts(chartElement, donutChartConfig);
        donutChart.render();
      }
    })
    .catch((error) => console.error("Error fetching chart data:", error));
})();
