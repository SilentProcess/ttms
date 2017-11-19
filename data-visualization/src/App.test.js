import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import Map from './Map';
it('renders without crashing', () => {
  const div = document.createElement('div');
  ReactDOM.render(<App />, div);
  const div2 = document.createElement('div');
  ReactDOM.render(<Map />, div);
});