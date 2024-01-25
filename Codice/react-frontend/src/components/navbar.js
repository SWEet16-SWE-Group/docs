import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';

class Navbar extends Component {
  constructor(props) {
    super(props);
    this.state = {
      idCliente: "",
      cliente : [],
      idRistorante: "",
      ristorante : []
    }
  }
    
    componentDidMount() 
    {  
      let id_cliente=-1;
      let id_ristorante=-1;
      if(localStorage && localStorage.getItem('idc')) 
      {
         id_cliente = JSON.parse(localStorage.getItem('idc'));
         this.setState({ idCliente: id_cliente });
         axios.post("http://localhost:8888/select_cliente.php", {id_cliente}).then(response => {
          this.setState({ cliente: response.data });
        });
      }
      else if(localStorage && localStorage.getItem('idr')) 
      {
          id_ristorante = JSON.parse(localStorage.getItem('idr'));
         this.setState({ idRistorante: id_ristorante });
         axios.post("http://localhost:8888/select_ristorante.php", {id_ristorante}).then(response => {
          this.setState({ ristorante: response.data });
        });
      }

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
                    {pageName.split('/')[1] === "dettagliprenotazione" && (
                    <>
                      <Link to="/dashboardristoratori" className="text-decoration-none link-secondary mx-3">Dashboard</Link>
                      <Link to="#" className="text-decoration-none link-primary mx-3">Dettagli</Link>
                    </>
                  )}
                  {pageName === "/dashboardclienti" && (
                    <>
                      <Link to="#" className="text-decoration-none link-primary mx-3">Dashboard</Link>
                      <Link to="/formprenotazione" className="text-decoration-none link-secondary mx-3">Prenotazione</Link>
                    </>
                  )}
                  {pageName === "/formprenotazione" && (
                    <>
                      <Link to="/dashboardclienti" className="text-decoration-none link-secondary mx-3">Dashboard</Link>
                      <Link to="#" className="text-decoration-none link-primary mx-3">Prenotazione</Link>
                    </>
                  )} 
                  {pageName === "/menu" && (
                    <>
                      <Link to="/dashboardclienti" className="text-decoration-none link-secondary mx-3">Dashboard</Link>
                      <Link to="/formprenotazione" className="text-decoration-none link-secondary mx-3">Prenotazione</Link>
                      <Link to="#" className="text-decoration-none link-primary mx-3">Ordinazione</Link>
                    </>
                  )}
                  {pageName.split('/')[1] === "dettaglipietanza" && (
                    <>
                      <Link to="/dashboardclienti" className="text-decoration-none link-secondary mx-3">Dashboard</Link>
                      <Link to="/formprenotazione" className="text-decoration-none link-secondary mx-3">Prenotazione</Link>
                      <Link to="/menu" className="text-decoration-none link-secondary mx-3">Ordinazione</Link>
                      <Link to="#" className="text-decoration-none link-primary mx-3">Dettagli</Link>
                    </>
                  )}
                  {(pageName.split('/')[1] === "ordinazioni") && (
                    <>
                      <Link to="/dashboardclienti" className="text-decoration-none link-secondary mx-3">Dashboard</Link>
                      <Link to="/formprenotazione" className="text-decoration-none link-secondary mx-3">Prenotazione</Link>
                      <Link to="#" className="text-decoration-none link-primary mx-3">Ordinazioni</Link>
                    </>
                  )}

                  <Link to="/login" className="text-decoration-none link-secondary mx-3" onClick={() =>this.handlePage("Login")}>Logout</Link>
                </div>

                <h1 className="mx-auto col-3 text-center fst-italic fw-lighter">Easymeal</h1>
                
                  {this.state.cliente && this.state.cliente.map((rs, index) => (
                    
                    <h5 key={index} className="fw-normal mx-auto col-3 text-end">{rs.Username}</h5>
                  ))}
                  {this.state.ristorante && this.state.ristorante.map((rs, index) => (
                    
                    <h5 key={index} className="fw-normal mx-auto col-3 text-end">{rs.Ragione_sociale}</h5>
                  ))}
              </nav>
            </>
            )
          );
        }
}
          
export default Navbar;