import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';

import Navbar from './navbar';

class DettagliPrenotazione extends Component {
  constructor(props) {
    super(props);
    this.state = {
        prenotazione: [],
        ordinazioni: [],
        ingredienti: [],
        rimossi: [],
        quantita: 1
    };
    this.handleSubmit = this.handleSubmit.bind(this);
    this.rimuoviParole = this.rimuoviParole.bind(this);
   }

   componentDidMount() {
    let pathname = window.location.pathname;
    let id_prenotazione = pathname.split('/')[2];

    axios.post("http://localhost:8888/select_prenotazione.php ", { id_prenotazione }).then(response =>
      this.setState({ prenotazione: response.data}, () => {
        if(this.state.prenotazione[0]!==null)
        {
          axios.post('http://localhost:8888/select_multiple_ordine_confermato.php', { id_prenotazione }).then(response => {
              let ingredientiArray = response.data.map(item => {
                if (item.Ingredienti !== null) 
                {
                  return item.Ingredienti.split(',').map(ingrediente => ingrediente.trim());
                } 
                else 
                {
                  return [];
                }
              });
              let rimossiArray = response.data.map(item => {
                if (item.Ingredienti_rimossi !== null) 
                {
                  return item.Ingredienti_rimossi.split(',').map(rimosso => rimosso.trim());
                } 
                else 
                {
                  return [];
                }
              });
            this.setState({ ordinazioni: response.data, ingredienti: ingredientiArray, rimossi: rimossiArray}, () => {
              this.rimuoviParole();
            })
            })
        }
    }))
  }

  rimuoviParole = () => {
    const { ingredienti, rimossi } = this.state;

    const nuovoArrayIngredienti = ingredienti.map((ingredientiAttuali, index) => {
      const rimossiAttuali = rimossi[index];

      const nuoviIngredienti = ingredientiAttuali.filter(parola => !rimossiAttuali.includes(parola));
      return nuoviIngredienti.join(", ");
    });

    this.setState({ ingredienti: nuovoArrayIngredienti });
  };

  handleSubmit = (event) => {

    event.preventDefault();

    const cliente = JSON.parse(localStorage.getItem('idc'));
    const tavolo = this.state.prenotazione[0].Id_tavolo;
    const ristorante = this.state.prenotazione[0].Id_ristorante;
    const prodotto = this.state.pietanza[0].ID_prodotto;
    const porzioni = this.state.quantita;
    const tot = this.state.pietanza[0].Prezzo * porzioni;
    const rimossi = this.state.rimossi.join(', ')


    const insert = [
      {
        id_cliente: cliente,
        id_tavolo: tavolo,
        id_ristorante: ristorante,
        id_prodotto: prodotto,
        quantita: porzioni,
        totale: tot,
        ingredienti_rimossi: rimossi
      }
    ]

    axios
      .post("http://localhost:8888/insert_ordine.php", insert[0])

  };

  render() {

    return (
      <>
      <Navbar key="navbar-key" />
      <div className="container-fluid p-auto border width-95 rounded border-2 margin-tb h-auto">
      {this.state.prenotazione.length !== 0 && this.state.prenotazione.map((rs, index) => (
            <div key={index} className="mt-5 d-flex justify-content-center">
                <Link to={`/dashboardristoratori`} className="btn btn-outline-primary btn-outline btn-lg w-100 m-2">TORNA ALLE PRENOTAZIONI</Link>
            </div>
          ))}
          <h1 className="my-5 d-flex justify-content-center">PRENOTAZIONE NUMERO: 
            {this.state.prenotazione && this.state.prenotazione.map((rs, index) => (
              <div className="mx-3" key={index}>{rs.ID_prenotazione}</div>
            ))} 
          </h1>
          <div className="row mb-5 mx-3">
            <div className="col-12" >
              <table className="table-attive table">
                <thead className="thead-dark">
                  <tr>
                    <th>Pietanza</th>
                    <th>Quantità</th>
                    <th>Ingredienti rimossi</th>
                    <th>Ingredienti necessari</th>
                    <th>Orario</th>
                    <th>Cliente</th>
                  </tr>
                </thead>
                <tbody>
                  {this.state.ordinazioni.length !== 0 && this.state.ordinazioni.map((rs, index) => (
                    <tr key={index} >
                      <td>{rs.Nome}</td>
                      <td>{rs.Quantita}</td>
                      <td>{rs.Ingredienti_rimossi ? rs.Ingredienti_rimossi : "Nessuno"}</td>
                      <td>{this.state.ingredienti[index]}</td>
                      <td>{rs.Orario}</td>
                      <td>{rs.Username}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
          </div>
        </div>
        <div className="row my-5">
            <div className="col-6">
                <button type="submit" className="btn btn-outline-success btn-lg w-100 my-2">ACCETTA</button>
            </div>
            <div className="col-6">
                <button type="submit" className="btn btn-outline-danger btn-lg w-100 my-2">RIFIUTA</button>
            </div>
        </div>
      </div>
      </>
    );
  }
}

export default DettagliPrenotazione;