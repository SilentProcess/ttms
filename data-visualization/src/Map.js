import React, { Component } from 'react';
import AmCharts from "@amcharts/amcharts3-react";
import './Map.css';
var markerSVG = "M-5,0a5,5 0 1,0 10,0a10,10 0 1,0 -10,0";
function generateData() {
  var dataProvider="JSON mis data";

  return dataProvider;
}
class Map extends Component {
  constructor(props) {
    super(props);

    this.state = {
      dataProvider: generateData(),
      timer: null
    };
  }

  componentDidMount() {
    this.setState({
      // Update the chart dataProvider every 5 seconds
      timer: setInterval(() => {
        this.setState({
          dataProvider: generateData()
        });
      }, 5000)
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

  "dataProvider": {
    "map": "worldLow",
    "images": [ {
      "svgPath": markerSVG,
      "zoomLevel": 5,
      "scale": 0.5,
      "title": "Vienna",
      "latitude": 48.2092,
      "longitude": 16.3728
    }, {
      "svgPath": markerSVG,
      "zoomLevel": 5,
      "scale": 0.5,
      "title": "Minsk",
      "latitude": 53.9678,
      "longitude": 27.5766
    }, {
      "svgPath": markerSVG,
      "zoomLevel": 5,
      "scale": 0.5,
      "title": "Brussels",
      "latitude": 50.8371,
      "longitude": 4.3676
    }, {
      "svgPath": markerSVG,
      "zoomLevel": 5,
      "scale": 0.5,
      "title": "Sarajevo",
      "latitude": 43.8608,
      "longitude": 18.4214
    }, {
      "svgPath": markerSVG,
      "zoomLevel": 5,
      "scale": 0.5,
      "title": "Sofia",
      "latitude": 42.7105,
      "longitude": 23.3238
    }, {
      "svgPath": markerSVG,
      "zoomLevel": 5,
      "scale": 0.5,
      "title": "Zagreb",
      "latitude": 45.8150,
      "longitude": 15.9785
    } ]
  }
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