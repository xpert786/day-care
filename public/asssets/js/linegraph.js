$(document).ready(function(){
    $.ajax({
      url : "followersdata",
      type : "GET",
      success : function(data){
        var userid = [];
        var facebook_follower = [];
        var twitter_follower = [];
        var googleplus_follower = [];

        for(var i in data) {
          userid.push(data[i].mon);
          facebook_follower.push(data[i].users_reg);
          twitter_follower.push(data[i].rev_gen);
          googleplus_follower.push(data[i].ord_plc);
        }

        var chartdata = {        
          labels: userid,
          datasets: [
            {
              label: "Users registered",
              fill: false,
              lineTension: 0.1,
              backgroundColor: "rgba(59, 89, 152, 0.75)",
              borderColor: "rgba(59, 89, 152, 1)",
              pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
              pointHoverBorderColor: "rgba(59, 89, 152, 1)",
              data: facebook_follower
            },
            {
              label: "Revenue generated",
              fill: false,
              lineTension: 0.1,
              backgroundColor: "rgba(29, 202, 255, 0.75)",
              borderColor: "rgba(29, 202, 255, 1)",
              pointHoverBackgroundColor: "rgba(29, 202, 255, 1)",
              pointHoverBorderColor: "rgba(29, 202, 255, 1)",
              data: twitter_follower
            },
            {
              label: "Requests placed",
              fill: false,
              lineTension: 0.1,
              backgroundColor: "rgba(211, 72, 54, 0.75)",
              borderColor: "rgba(211, 72, 54, 1)",
              pointHoverBackgroundColor: "rgba(211, 72, 54, 1)",
              pointHoverBorderColor: "rgba(211, 72, 54, 1)",
              data: googleplus_follower
            }
          ]
        };

        var ctx = $("#mycanvas");

        var LineGraph = new Chart(ctx, {
          type: 'line',
          data: chartdata
        });
      },
      error : function(data) {

      }
    });
  });
