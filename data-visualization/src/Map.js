import React, { Component } from 'react';
import AmCharts from "@amcharts/amcharts3-react";
import './Map.css';
import axios from 'axios';

class Map extends Component {
  constructor(props) {
    super(props);
		this.state = {
         dataProvider: [],
   }
   axios.get('./map.json') 
    .then(res => {
        this.setState({ dataProvider: res.data });  
		console.log(this.state.dataProvider);
   });
   console.log(this.state.dataProvider);

}

componentDidMount() {
    this.setState({
      // Update the chart dataProvider every 3 seconds
      timer: setInterval(() => {
        axios.get('./map.json') 
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
  "type": "map",
  "theme": "dark",
  "projection": "miller",

  "imagesSettings": {
    "rollOverColor": "#089282",
    "rollOverScale": 3,
    "selectedScale": 3,
    "selectedColor": "#089282",
    "color": "yellow"
  },

  "areasSettings": {
    "unlistedAreasColor": "#15A892"
  },

  "dataProvider": this.state.dataProvider


};

// add events to recalculate map position when the map is moved or zoomed


 return (
      <div className="Map">
        <AmCharts.React style={{ width: "100%", height: "500px" }} options={config} />
      </div>
    );
  }
}

export default Map;
