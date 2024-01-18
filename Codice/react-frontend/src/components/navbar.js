import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';

class Navbar extends Component {
  constructor(props) {
    super(props);
    this.state = {
      idCliente: "",
      cliente : []
    }
  }
    
    componentDidMount() 
    {  
      let id_cliente=-1;
      if (localStorage && localStorage.getItem('idc')) 
      {
         id_cliente = JSON.parse(localStorage.getItem('idc'));
         this.setState({ idCliente: id_cliente });
      }

      axios.post("http://localhost:8888/select_cliente.php", {id_cliente}).then(response => {
        this.setState({ cliente: response.data });
      });
    }

      render() 
      {
        let pageName=window.location.pathname;
      
          return (
             (pageName !== "/login" && pageName !== "/")  && (
              <>
              <nav className="navbar navbar-expand-lg navbar-light bg-light fixed-top">
                <div className="container-fluid mx-auto col-3 text-start">
                  {pageName === "/dashboardristoratori" && (
                    <>
                      <Link to="#" className="text-decoration-none link-primary mx-3">Dashboard</Link>
                    </>
                  )}
                  {pageName === "/dashboardclienti" && (
                    <>
                      <Link to="#" className="text-decoration-none link-primary mx-3">Dashboard</Link>
                      <Link to="/formprenotazione" className="text-decoration-none link-secondary mx-3">Prenotazione</Link>
                      <Link to="/ordinazione" className="text-decoration-none link-secondary mx-3">Ordinazione</Link>
                    </>
                  )}
                  {pageName === "/formprenotazione" && (
                    <>
                      <Link to="/dashboardclienti" className="text-decoration-none link-secondary mx-3">Dashboard</Link>
                      <Link to="#" className="text-decoration-none link-primary mx-3">Prenotazione</Link>
                      <Link to="/ordinazione" className="text-decoration-none link-secondary mx-3">Ordinazione</Link>
                    </>
                  )}
                  {(pageName === "/ordinazione" || pageName.split('/')[1] === "dettagli") && (
                    <>
                      <Link to="/dashboardclienti" className="text-decoration-none link-secondary mx-3">Dashboard</Link>
                      <Link to="/formprenotazione" className="text-decoration-none link-secondary mx-3">Prenotazione</Link>
                      <Link to="#" className="text-decoration-none link-primary mx-3">Ordinazione</Link>
                    </>
                  )}
                  <Link to="/login" className="text-decoration-none link-secondary mx-3">Logout</Link>
                </div>

                <h1 className="mx-auto col-3 text-center fst-italic fw-lighter">Easymeal</h1>
                
                  {this.state.cliente.map((rs, index) => (
                    
                    <h5 key={index} className="fw-normal mx-auto col-3 text-end">{rs.Username}</h5>
                  ))}
              </nav>
            </>
            )
          );
        }
}
          
export default Navbar;