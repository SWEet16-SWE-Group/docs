import React, { Component } from 'react';
import axios from 'axios';
import { Navigate } from "react-router-dom";
import "../App.css"

class DashboardClienti extends Component {
  constructor(props) {
    super(props);
    this.state = {
      prenotazioni: [],
      scadute: [],
      ristorante: [],
      cliente: [],
      submittedBack: false,
      submittedPrenotazione: false,
    };
    this.handleBack = this.handleBack.bind(this);
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

    axios.post("http://localhost:8888/select_cliente.php ", ricerca_cliente[0], { headers: { 'Content-Type': 'application/json' } }).then(response => {
      this.setState({ cliente: response.data });
    })

    axios.post("http://localhost:8888/select_prenotazioni_cliente.php ", ricerca_cliente[0], { headers: { 'Content-Type': 'application/json' } }).then(response => {
      this.setState({ prenotazioni: response.data });
    })

    axios.post("http://localhost:8888/select_prenotazioni_cliente_scadute.php ", ricerca_cliente[0], { headers: { 'Content-Type': 'application/json' } }).then(response => {
      this.setState({ scadute: response.data });
    })

  }

  getColor = (stato) => {
    if (stato === 0) return 'red';
    if (stato === 1) return 'green';
    return 'white';
  };

  getColorHeader = () => {
    return 'gray';
  };

  handleBack = () => (event) => {
    this.setState({ submittedBack: true });
  }

  handlePrenotazione = () => (event) => {
    this.setState({ submittedPrenotazione: true });
  }

  render() {
    return (
      <div>
        {this.state.submittedBack && (
          <Navigate to="/login"
          />)}
        {this.state.submittedPrenotazione && (
          <Navigate to="/form_prenotazione"
          />)}
          <br></br>
          <h1 className="my-5 d-flex justify-content-center">Lista prenotazioni cliente: {this.state.cliente.map((rs, index) => (<div key={index}>{rs.Username}</div>))} </h1>
          <div>
            <button onClick={this.handleBack()} type="button" className="btn-partecipanti btn btn-outline-primary back">Back</button>
            <button onClick={this.handlePrenotazione()} type="button" className="btn-partecipanti btn btn-outline-primary">Nuova prenotazione</button>
          </div>
          <h3 className="attive"> Attive</h3>
          <h3 className="scadute"> Scadute</h3>
          <table className="table-attive">
            <thead>
              <tr style={{ background: this.getColorHeader() }} >
                <th>Prenotazione</th>
                <th>Ristorante</th>
                <th>N. persone</th>
                <th>Giorno</th>
                <th>Orario</th>
              </tr>
            </thead>
            <tbody>
              {this.state.prenotazioni.length !== 0 && this.state.prenotazioni.map((rs, index) => (
                <tr style={{ background: this.getColor(rs.Stato) }} key={index} >
                  <td>{rs.ID_prenotazione}</td>
                  <td>{rs.Ragione_sociale}</td>
                  <td>{rs.Num_persone}</td>
                  <td>{rs.Data_prenotazione}</td>
                  <td>{rs.Orario_arrivo} - {rs.Orario_partenza}</td>
                </tr>
              ))}
            </tbody>
          </table>
          <table className="table-scadute">
            <thead>
              <tr style={{ background: this.getColorHeader() }} >
                <th>Prenotazione</th>
                <th>Ristorante</th>
                <th>N. persone</th>
                <th>Giorno</th>
                <th>Orario</th>
              </tr>
            </thead>
            <tbody>
              {this.state.scadute.length !== 0 && this.state.scadute.map((rs, index) => (
                <tr style={{ background: this.getColor(rs.Stato) }} key={index} >
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
    );
  }
}

export default DashboardClienti;