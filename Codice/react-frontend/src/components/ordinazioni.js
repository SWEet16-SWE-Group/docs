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
    localStorage.setItem('idp', id_prenotazione);
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

    const ordinazioniPerUtente = {};
    this.state.altreordinazioni.forEach((rs) => {
      if (!ordinazioniPerUtente[rs.Username]) {
        ordinazioniPerUtente[rs.Username] = [];
      }
      ordinazioniPerUtente[rs.Username].push(rs);
    });

    return (
      <>
        <Navbar key="navbar-key" />
        <div className="container-fluid p-auto w-75 border rounded border-2 margin-tb gx-0">
          <div className="row mb-5 mx-3">
            <h3 className="attive text-center my-4">I TUOI ORDINI</h3>
            {this.state.ordinazione[0] && (
              <>
            <table className="table-attive table">
              <thead className="thead-dark">
                <tr>
                  <th className="col-3">Pietanza</th>
                  <th className="col-1">Quantità</th>
                  <th className="col-3">Ingredienti Rimossi</th>
                  <th className="col-1">Totale</th>
                  <th className="col-2">Orario</th>
                  <th>
                  {!this.state.confermato && (
                    <button type="button" className="btn btn-primary btn-sm" onClick={this.handleConferma}>CONFERMA</button>
                  )}
                  {this.state.confermato && (
                    <button type="button" className="btn btn-primary btn-sm" onClick={this.handleConferma} disabled>CONFERMATO</button>
                  )}
                  </th>
                </tr>
              </thead>
              <tbody>
                {this.state.ordinazione.length !== 0 && this.state.ordinazione.map((rs, index) => (
                  <tr key={index} >
                    <td className="col-3">{rs.Nome}</td>
                    <td className="col-1">{rs.Quantita}</td>
                    <td className="col-3">{rs.Ingredienti_rimossi===null ? "Nessuno" : rs.Ingredienti_rimossi}</td>
                    <td className="col-1">€{rs.Totale}</td>
                    <td className="col-2">{rs.Orario}</td>
                    <td className="col-2"></td>
                  </tr>
                ))}
              </tbody>
            </table>
            </>
            )}
          </div>
            <div className="mt-5 d-flex justify-content-center">
                <Link to="/menu" className="btn btn-primary btn-lg w-100 m-2">ORDINA DAL MENU</Link>
            </div>
        </div>

        {Object.entries(ordinazioniPerUtente).map(([username, ordinazioniUtente], index) => (
          <div key={index} className="container-fluid p-auto w-75 border rounded border-2 margin-tb gx-0">
            <div className="row mb-5 mx-3">
            <h3 className="attive text-center my-4">{username}</h3>
            <table className="table-attive table">
              <thead className="thead-dark">
                <tr>
                  <th className="col-3">Pietanza</th>
                  <th className="col-1">Quantità</th>
                  <th className="col-3">Ingredienti Rimossi</th>
                  <th className="col-1">Totale</th>
                  <th className="col-2">Orario</th>
                  {this.state.prenotazione.length !== 0 && this.state.prenotazione.map((rs, index) => (
                    <th key={index} className={rs.Stato === 1 ? "text-success" : "text-secondary"}>
                      {rs.Stato === 1 ? "CONFERMATO" : "DA CONFERMARE"}
                    </th>
                  ))}
                </tr>
              </thead>
              <tbody>
                {ordinazioniUtente.map((rs, index) => (
                  <tr key={index}>
                    <td  className="col-3">{rs.Nome}</td>
                    <td  className="col-1">{rs.Quantita}</td>
                    <td  className="col-3">{rs.Ingredienti_rimossi === null ? "Nessuno" : rs.Ingredienti_rimossi}</td>
                    <td  className="col-1">€{rs.Totale}</td>
                    <td  className="col-2">{rs.Orario}</td>
                    <td></td>
                  </tr>
                ))}
              </tbody>
            </table>
            </div>
          </div>
        ))}
      </>
    );
  }
}

export default DettagliPietanza;