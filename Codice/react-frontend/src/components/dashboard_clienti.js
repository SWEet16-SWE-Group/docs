import React, { Component } from 'react';
import axios from 'axios';
import "../App.css"

import Navbar from "./navbar";

class DashboardClienti extends Component {
  constructor(props) {
    super(props);
    this.state = {
      prenotazioni: [],
      scadute: [],
      ristorante: [],
      cliente: [],
    };
  }

  componentDidMount() {
    let id_cliente = -1;
    let utente = "";
    if (localStorage && localStorage.getItem('idc')) { id_cliente = JSON.parse(localStorage.getItem('idc')) }
    if (localStorage && localStorage.getItem('idu')) { utente = JSON.parse(localStorage.getItem('idu')) }
    this.setState({ id_cliente: id_cliente });
    this.setState({ utente: utente });
    const ricerca_cliente = [
      {
        id_cliente: id_cliente,
        utente: utente,
      }
    ]

    axios.post("http://localhost:8888/select_cliente.php ", ricerca_cliente[0]).then(response => {
      this.setState({ cliente: response.data });
    })

    axios.post("http://localhost:8888/select_prenotazioni_cliente.php ", ricerca_cliente[0]).then(response => {
      this.setState({ prenotazioni: response.data });
    })

    axios.post("http://localhost:8888/select_prenotazioni_cliente_scadute.php ", ricerca_cliente[0]).then(response => {
      this.setState({ scadute: response.data });
    })

  }

  getColor = (stato) => {
    if (stato === 0) return 'table-danger';
    if (stato === 1) return 'table-success';
    else return;
  };

  render() {
    return (
      <>
      <Navbar key="navbar-key" />
      <div className="container-fluid p-auto border width-95 rounded border-2 margin-tb h-auto">
          <h1 className="my-5 d-flex justify-content-center">LISTA PRENOTAZIONI CLIENTE: 
            {this.state.cliente.map((rs, index) => (
              <div className="mx-3" key={index}>{rs.Username}</div>
            ))} 
          </h1>
          <div className="row mb-5 mx-3">
            <div className="col-5" >
              <h3 className="attive text-center mb-4"> Attive</h3>
              <table className="table-attive table">
                <thead className="thead-dark">
                  <tr>
                    <th>Prenotazione</th>
                    <th>Ristorante</th>
                    <th>N. persone</th>
                    <th>Giorno</th>
                    <th>Orario</th>
                  </tr>
                </thead>
                <tbody>
                  {this.state.prenotazioni.length !== 0 && this.state.prenotazioni.map((rs, index) => (
                    <tr className={this.getColor(rs.Stato)} key={index} >
                      <td>{rs.ID_prenotazione}</td>
                      <td>{rs.Ragione_sociale}</td>
                      <td>{rs.Num_persone}</td>
                      <td>{rs.Data_prenotazione}</td>
                      <td>{rs.Orario_arrivo} - {rs.Orario_partenza}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
          </div>
          <div className="col-2"></div>
            <div className="col-5" >
              <h3 className="scadute text-center mb-4"> Scadute</h3>
              <table className="table-scadute table">
                <thead className="thead-dark">
                  <tr>
                    <th>Prenotazione</th>
                    <th>Ristorante</th>
                    <th>N. persone</th>
                    <th>Giorno</th>
                    <th>Orario</th>
                  </tr>
                </thead>
                <tbody>
                  {this.state.scadute.length !== 0 && this.state.scadute.map((rs, index) => (
                    <tr className={this.getColor(rs.Stato)} key={index} >
                      <td>{rs.ID_prenotazione}</td>
                      <td>{rs.Ragione_sociale}</td>
                      <td>{rs.Num_persone}</td>
                      <td>{rs.Data_prenotazione}</td>
                      <td>{rs.Orario_arrivo} - {rs.Orario_partenza}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
          </div>
        </div>
      </div>
      </>
    );
  }
}

export default DashboardClienti;