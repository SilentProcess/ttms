import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import Map from './Map';
import Radar from './Radar';
import Lines from './Lines';
import './index.css';

ReactDOM.render(
  <App />,
  document.getElementById('root')
);
ReactDOM.render(
  <Map />,
  document.getElementById('map')
);
ReactDOM.render(
  <Radar />,
  document.getElementById('radar')
);
ReactDOM.render(
  <Lines />,
  document.getElementById('lines')
);

