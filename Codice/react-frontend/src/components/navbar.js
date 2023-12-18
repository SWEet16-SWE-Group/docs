import React, { Component } from 'react';
import axios from 'axios';

class Navbar extends Component {
  constructor() {
    super();
    this.state = {
      cliente : []
    }
  }
    
    componentDidMount() {  
      axios.get("http://localhost:8888/select_single_cliente.php").then(response => {
        this.setState({ cliente: response.data });
      });
      }


      render() 
      {
          return (
              <nav className="navbar navbar-dark bg-dark fixed-top">
                {this.state.cliente.map((rs, index) => (
                    <div key={index} className="container-fluid d-flex justify-content-between">
                        <div className="navbar-brand h1">Menu</div>
                        <div className="navbar-brand h1">Easymeal</div>
                        <div className="navbar-brand h1">{rs.Username}</div>
                    </div>
                ))}
                </nav>
            );
        }
}
          
export default Navbar;