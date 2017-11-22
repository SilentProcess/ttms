import React, { Component } from 'react';
import AmCharts from "@amcharts/amcharts3-react";
import axios from 'axios';

class Radar extends Component {
  constructor(props) {
    super(props);
		this.state = {
         dataProvider: [],
		 dataProvider2: [],
   }
   axios.all([
    axios.get('/radar.json'),
    axios.get('/radar2.json')
  ])
    .then(axios.spread((radar,radar2) => {
        this.setState({ dataProvider: radar.data,
						dataProvider2: radar2.data})
						console.log(this.state.dataProvider);
						console.log(this.state.dataProvider2);

   }))
   //console.log(this.state.dataProvider);

}

componentDidMount() {
    this.setState({
      // Update the chart dataProvider every 30 seconds
      timer: setInterval(() => {
        axios.all([
    axios.get('/radar.json'),
    axios.get('/radar2.json')
  ])
	.then(axios.spread((radar,radar2) => {
        this.setState({ dataProvider: radar.data,
						dataProvider2: radar2.data})

		}))
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
   "titles": [
		{
			"text": "Käyttäjätunnukset",
			"size": 15
		}]

}
 const config2 = {
	"type": "radar",
  "theme": "dark",
  "dataProvider": this.state.dataProvider2,
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
    "valueField": "attempts",
  } ],
  "categoryField": "password",
  "titles": [
		{
			"text": "Salasanat",
			"size": 15,
			"color": "white"
		}]

}


 return (
      <div className="container">
        <AmCharts.React style={{ width: "500px", height: "400px" }} options={config} />
		<AmCharts.React style={{ width: "500px", height: "400px" }} options={config2} />
      </div>
	  
    );
  }
}

export default Radar;
