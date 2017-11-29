import React, { Component } from 'react';
import axios from 'axios';

class Lines extends Component {
	
	constructor(props) {
    super(props);
		this.state = {
         linesArray: []
   }
	axios.get('/ajax/get-datarow.php') 
    .then(res => {
        this.setState({ linesArray: res.data });  
		//console.log(this.state.dataProvider);
   });
	
	
	}
	
	componentDidMount() {
    this.setState({
      // Update the chart dataProvider every 3 seconds
      timer: setInterval(() => {
        axios.get('/ajax/get-datarow.php') 
			.then(res => {
				this.setState({ linesArray: res.data });  
			//console.log(this.state.dataProvider);
		});
      }, 30000)
    });
  }

  componentWillUnmount() {
    clearInterval(this.state.timer);
  }
  
  render() {
	return (
      <table>
	<tr>
	<th>IP address</th>
	<th>Username</th>
	<th>Password</th>
	<th>Timestamp</th>
	</tr>
	{this.state.linesArray.map(function(item, key) {
               return (
                  <tr key = {key}>
			<td>{item.ip}</td>
			<td>{item.username}</td>
			<td>{item.password}</td>
			<td>{item.timestamp}</td>
                  </tr>		 
                )
             
             })}
	</table>
    )
	  
	  
  }
}
export default Lines;

 
