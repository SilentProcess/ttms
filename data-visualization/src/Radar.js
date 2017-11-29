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
	  //this is used to make 2 axios calls compined
   axios.all([
    axios.get('/ajax/get-usernames.php'),
    axios.get('/ajax/get-passwords.php')
  ])
	  //axios.spread is here so both results can be used for differend arrays
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
    axios.get('/ajax/get-usernames.php'),
    axios.get('/ajax/get-passwords.php')
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
	//here two differend configuration variables are made
render() {
    const config = {
	"type": "radar",
  "theme": "dark",
  "dataProvider": this.state.dataProvider,
  "color": "#FCDAFF",
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
			"text": "Yleisimmät käyttäjätunnukset",
			"size": 17,
			"bold": false,
			"color": "#F9BAFF",
		}]

}
 const config2 = {
	"type": "radar",
  "theme": "dark",
  "dataProvider": this.state.dataProvider2,
  "color": "#FCDAFF",
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
			"text": "Yleisimmät salasanat",
			"size": 17,
			"color": "#F9BAFF",
			"bold": false,
		}]

}



//both are returned inside the same div
 return (
      <div className="radarcontainer">
        <AmCharts.React style={{ width: "50%", height: "400px"  }} options={config} />
		<AmCharts.React style={{ width: "50%", height: "400px"  }} options={config2} />
      </div>
	  
    );
  }
}

export default Radar;
