import React, { Component } from 'react';
import AmCharts from "@amcharts/amcharts3-react";
import axios from 'axios';

class Radar extends Component {
  constructor(props) {
    super(props);
		this.state = {
         dataProvider: [],
   }
   axios.get('./radar.json') 
    .then(res => {
        this.setState({ dataProvider: res.data });  
		console.log(this.state.dataProvider);
   });
   //console.log(this.state.dataProvider);

}

componentDidMount() {
    this.setState({
      // Update the chart dataProvider every 3 seconds
      timer: setInterval(() => {
        axios.get('./radar.json') 
			.then(res => {
				this.setState({ dataProvider: res.data });  
			console.log(this.state.dataProvider);
		});
      }, 30000)
    });
  }

  componentWillUnmount() {
    clearInterval(this.state.timer);
  }
render() {
    const config = {
	"type": "radar",
  "theme": "dark",
  "dataProvider": this.state.dataProvider,
  "valueAxes": [ {
    "axisTitleOffset": 20,
    "minimum": 0,
    "axisAlpha": 0.15
  } ],
  "startDuration": 2,
  "graphs": [ {
    "balloonText": "[[value]] Attempts",
    "bullet": "round",
    "lineThickness": 2,
    "valueField": "attempts"
  } ],
  "categoryField": "username",

}

// add events to recalculate map position when the map is moved or zoomed


 return (
      <div className="Radar">
        <AmCharts.React style={{ width: "500px", height: "400px" }} options={config} />
      </div>
    );
  }
}

export default Radar;
