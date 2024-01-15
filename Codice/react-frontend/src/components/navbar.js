import React, { Component } from 'react';
import { Link, Outlet } from 'react-router-dom';
import axios from 'axios';

class Navbar extends Component {
  constructor(props) {
    super(props);
    this.state = {
      pageName : "Login",
      idCliente: "",
      cliente : []
    }
    this.handlePage = this.handlePage.bind(this);
  }
    
    componentDidMount() 
    {  
      let id_cliente=-1;
      if (localStorage && localStorage.getItem('idc')) 
      {
         id_cliente = JSON.parse(localStorage.getItem('idc'));
         this.setState({ idCliente: id_cliente });
      }

      axios.get("http://localhost:8888/select_single_cliente.php").then(response => {
        this.setState({ cliente: response.data });
      });
    }

    handlePage = (selectedPage) => {
      this.setState({ pageName: selectedPage });
    };

      render() 
      {
        const {pageName } = this.state;
      
          return (
             pageName !== "Login" && (
              <>
              <nav className="navbar navbar-expand-lg navbar-light bg-light fixed-top">
                <div className="container-fluid mx-auto col-3 text-start">
                  {pageName === "Dashboard Clienti" && (
                    <>
                      <Link to="#" className="text-decoration-none link-primary mx-3">Dashboard</Link>
                      <Link to="/form_prenotazione" className="text-decoration-none link-secondary mx-3" onClick={() =>this.handlePage("Form Prenotazione")}>Prenotazione</Link>
                    </>
                  )}
                  {pageName === "Form Prenotazione" && (
                    <>
                      <Link to="/dashboardclienti" className="text-decoration-none link-secondary mx-3" onClick={() =>this.handlePage("Dashboard Clienti")}>Dashboard</Link>
                      <Link to="#" className="text-decoration-none link-primary mx-3">Prenotazione</Link>
                    </>
                  )}
                  <Link to="/login" className="text-decoration-none link-secondary mx-3" onClick={() =>this.handlePage("Login")}>Logout</Link>
                </div>

                <h1 className="mx-auto col-3 text-center fst-italic fw-lighter">Easymeal</h1>
                
                  {this.state.cliente.map((rs, index) => (
                    
                    <h5 key={index} className="fw-normal mx-auto col-3 text-end">{rs.Username}</h5>
                  ))}
              </nav>

            <Outlet />
            </>
            )
          );
        }
}
          
export default Navbar;