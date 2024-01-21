import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';

import Navbar from './navbar';

class DettagliPietanza extends Component {
  constructor(props) {
    super(props);
    this.state = {
        idcliente: "",
        username: "",
        prenotazione: [],
        ordinazione: [],
        altreordinazioni: [],
        confermato: localStorage.getItem('confermato') === 'true'
    };
    this.handleConferma = this.handleConferma.bind(this);
   }

   componentDidMount() {
    let pathname = window.location.pathname;
    let id_prenotazione = pathname.split('/')[2];
    let id_cliente = -1;
    let utente = "";
    if (localStorage && localStorage.getItem('idc')) { id_cliente = JSON.parse(localStorage.getItem('idc')) }
    if (localStorage && localStorage.getItem('idu')) { utente = JSON.parse(localStorage.getItem('idu')) }

    axios.post("http://localhost:8888/select_prenotazione.php ", { id_prenotazione }).then(response =>
      this.setState({ prenotazione: response.data, idcliente : id_cliente, username: utente }, () => {
        if(this.state.prenotazione[0]!==null)
        {
          axios.post('http://localhost:8888/select_multiple_ordine.php', { id_prenotazione, id_cliente }).then(response => {
            this.setState({ ordinazione: response.data }, () => {
                axios.post('http://localhost:8888/select_multiple_exeption_ordine.php', { id_prenotazione, id_cliente }).then(response => {
                  this.setState({ altreordinazioni: response.data })
                })
            })
          })
        }
      }))
  }

  handleConferma() {

    const cliente = JSON.parse(localStorage.getItem('idc'));
    const prenotazione = this.state.prenotazione[0].ID_prenotazione;

    const update = [
      {
        id_cliente: cliente,
        id_prenotazione: prenotazione
      }
    ]

    axios.post("http://localhost:8888/update_ordine.php", update[0]).then(
      () => {
        this.setState({ confermato: true }, () => {
          localStorage.setItem('confermato', 'true');
          axios.post('http://localhost:8888/select_multiple_ordine.php',  update[0]).then(response => {
            this.setState({ ordinazione: response.data })
        })
      })
    })
  }

  render() {

    return (
      <>
        <Navbar key="navbar-key" />
        <div className="container-fluid p-auto w-75 border rounded border-2 margin-tb gx-0">
          <div className="row mb-5 mx-3">
            <h3 className="attive text-center my-4">I TUOI ORDINI</h3>
            <table className="table-attive table">
              <thead className="thead-dark">
                <tr>
                  <th>Pietanza</th>
                  <th>Quantità</th>
                  <th>Ingredienti Rimossi</th>
                  <th>Totale</th>
                  <th>Orario</th>
                  <th>
                    <button type="button" className="btn btn-primary btn-sm" onClick={this.handleConferma} disabled={this.state.confermato}>CONFERMA</button>
                  </th>
                </tr>
              </thead>
              <tbody>
                {this.state.ordinazione.length !== 0 && this.state.ordinazione.map((rs, index) => (
                  <tr key={index} >
                    <td>{rs.Nome}</td>
                    <td>{rs.Quantita}</td>
                    <td>{rs.Ingredienti_rimossi===null ? "Nessuno" : rs.Ingredienti_rimossi}</td>
                    <td>€{rs.Totale}</td>
                    <td>{rs.Orario}</td>
                    <td>{rs.Conferma===1 ? "Confermato" : "Da confermare"}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
          {this.state.prenotazione.length !== 0 && this.state.prenotazione.map((rs, index) => (
            <div key={index} className="mt-5 d-flex justify-content-center">
                <Link to={`/menu/${rs.ID_prenotazione}`} className="btn btn-outline-primary btn-outline btn-lg w-100 m-2">ORDINA DAL MENU</Link>
            </div>
          ))}
        </div>

        <div className="container-fluid p-auto w-75 border rounded border-2 margin-tb gx-0">
          <div className="row mb-5 mx-3">
            <h3 className="attive text-center my-4">ALTRI ORDINI</h3>
            <table className="table-attive table">
              <thead className="thead-dark">
                <tr>
                  <th>Cliente</th>
                  <th>Pietanza</th>
                  <th>Quantità</th>
                  <th>Ingredienti Rimossi</th>
                  <th>Totale</th>
                  <th>Orario</th>
                  <th>Stato</th>
                </tr>
              </thead>
              <tbody>
                {this.state.altreordinazioni.length !== 0 && this.state.altreordinazioni.map((rs, index) => (
                  <tr key={index} >
                    <td>{rs.Username}</td>
                    <td>{rs.Nome}</td>
                    <td>{rs.Quantita}</td>
                    <td>{rs.Ingredienti_rimossi===null ? "Nessuno" : rs.Ingredienti_rimossi}</td>
                    <td>€{rs.Totale}</td>
                    <td>{rs.Orario}</td>
                    <td>{rs.Conferma===1 ? "Confermato" : "Da confermare"}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      </>
    );
  }
}

export default DettagliPietanza;