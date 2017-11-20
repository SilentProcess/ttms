import React, { Component } from 'react';
import AmCharts from "@amcharts/amcharts3-react";
import './App.css';
import axios from 'axios';

// Generate random data


// Component which contains the dynamic state for the chart
class App extends Component {
  constructor(props) {
    super(props);
		this.state = {
         dataProvider: [],
   }
   axios.get('./test.json') 
    .then(res => {
        this.setState({ dataProvider: res.data });  
		//console.log(this.state.dataProvider);
   });
  // console.log(this.state.dataProvider);

}



  componentDidMount() {
    this.setState({
      // Update the chart dataProvider every 3 seconds
      timer: setInterval(() => {
        axios.get('./test.json') 
			.then(res => {
				this.setState({ dataProvider: res.data });  
	//	console.log(this.state.dataProvider);
   });
      }, 15000)
    });
  }



  componentWillUnmount() {
    clearInterval(this.state.timer);
  }

  render() {
	  
    const config = {
      "type": "serial",
      "theme": "light",
      "marginRight": 40,
      "marginLeft": 40,
      "autoMarginOffset": 20,
      "mouseWheelZoomEnabled": true,
	  "zoomOutOnDataUpdate": false,
      "valueAxes": [{
        "id": "v1",
        "axisAlpha": 0,
        "position": "left",
        "ignoreAxisWidth": true
      }],
      "balloon": {
        "borderThickness": 1,
        "shadowAlpha": 0
      },
      "graphs": [{
        "id": "g1",
        "balloon":{
          "drop": true,
          "adjustBorderColor": false,
          "color":"#ffffff"
        },
        "bullet": "round",
        "bulletBorderAlpha": 1,
        "bulletColor": "#FFFFFF",
        "bulletSize": 5,
        "hideBulletsCount": 50,
        "lineThickness": 2,
        "title": "red line",
        "useLineColorForBulletBorder": true,
        "valueField": "value",
        "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
      }],
      "chartScrollbar": {
        "graph": "g1",
        "oppositeAxis": false,
        "offset":30,
        "scrollbarHeight": 80,
        "backgroundAlpha": 0,
        "selectedBackgroundAlpha": 0.1,
        "selectedBackgroundColor": "#888888",
        "graphFillAlpha": 0,
        "graphLineAlpha": 0.5,
        "selectedGraphFillAlpha": 0,
        "selectedGraphLineAlpha": 1,
        "autoGridCount": true,
        "color":"#AAAAAA"
      },
      "chartCursor": {
        "pan": true,
        "valueLineEnabled": true,
        "valueLineBalloonEnabled": true,
        "cursorAlpha":1,
        "cursorColor":"#258cbb",
        "limitToGraph":"g1",
        "valueLineAlpha":0.2,
        "valueZoomable": true
      },
      "valueScrollbar":{
        "oppositeAxis": false,
        "offset":50,
        "scrollbarHeight":10
      },
      "categoryField": "date",
      "categoryAxis": {
        "parseDates": true,
        "dashLength": 1,
        "minorGridEnabled": true
      },
      "dataProvider": this.state.dataProvider
	  
    };
	
	

    return (
      <div className="App">
        <AmCharts.React 
		style={{ width: "100%", height: "350px" }} options={config} ref={'chart1'}

		/>
      </div>
    );
  }
  
}

export default App;
