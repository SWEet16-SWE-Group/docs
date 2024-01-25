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
        quantita: [],
        ripristina: ""
    };
    this.handlePrenotazione = this.handlePrenotazione.bind(this);
    this.rimuoviParole = this.rimuoviParole.bind(this);
    this.calcolaFrequenza = this.calcolaFrequenza.bind(this);
   }

   componentDidMount() {
    let pathname = window.location.pathname;
    let id_prenotazione = pathname.split('/')[2];

    axios.post("http://localhost:8888/select_prenotazione.php ", { id_prenotazione }).then(response => {
      let stato=false;
      if(response.data[0].Stato!==null)
      {
        stato=true;
      }
      this.setState({ prenotazione: response.data, ripristina: stato}, () => {
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
    })
  })
  }

  rimuoviParole = () => {
    const { ingredienti, rimossi } = this.state;

    const nuovoArrayIngredienti = ingredienti.map((ingredientiAttuali, index) => {
      const rimossiAttuali = rimossi[index];

      const nuoviIngredienti = ingredientiAttuali.filter(parola => !rimossiAttuali.includes(parola));
      return nuoviIngredienti.join(", ");
    });

    this.setState({ ingredienti: nuovoArrayIngredienti }, () => {
      this.calcolaFrequenza();
    })
  };

  calcolaFrequenza = () => {
    const { ingredienti } = this.state;
  
    const testoIngredienti = ingredienti.join(', ');
    const parole = testoIngredienti.split(', ');
  
    const frequenzaParole = {};
    parole.forEach(parola => {
      if (!frequenzaParole[parola]) {
        frequenzaParole[parola] = 1;
      } else {
        frequenzaParole[parola]++;
      }
    });
  
    const arrayQuantita = Object.keys(frequenzaParole).map(parola => ({ parola, frequenza: frequenzaParole[parola] }));
  
    this.setState({ quantita: arrayQuantita });
  };

  handlePrenotazione = (stato) => (event) => {
    event.preventDefault();
    const prenotazione = this.state.prenotazione[0].ID_prenotazione;
    const aggiorna = [
      {
        id_prenotazione: prenotazione,
        stato: stato,
      }
    ]
    axios.post("http://localhost:8888/aggiorna_stato_prenotazione.php ", aggiorna[0]).then(() => {
      if(stato!==3) 
      {
        this.setState({ ripristina: true });
      }
      else
      {
        this.setState({ ripristina: false });
      }
    })

  }

  render() {

    return (
      <>
      <Navbar key="navbar-key" />
      <div className="container-fluid p-auto border width-95 rounded border-2 margin-tb h-auto">
          <div className="mt-5 d-flex justify-content-center">
              <Link to={`/dashboardristoratori`} className="btn btn-outline-primary btn-outline btn-lg w-100 m-2">TORNA ALLE PRENOTAZIONI</Link>
          </div>
          <h1 className="my-5 d-flex justify-content-center">PRENOTAZIONE NUMERO: 
            {this.state.prenotazione && this.state.prenotazione.map((rs, index) => (
              <div className="mx-3" key={index}>{rs.ID_prenotazione}</div>
            ))} 
          </h1>
          {this.state.ordinazioni.length !== 0 && (
            <>
          <div className="row mb-5 mx-3">
            <div className="col-12" >
              <table className="table">
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
        <div className="row mb-5 mx-3">
        <h3 className="my-5 d-flex justify-content-center">INVENTARIO PRENOTAZIONE</h3>
        <div className="col-4" ></div>
            <div className="col-4" >
              <table className="table">
                <thead className="thead-dark">
                  <tr>
                    <th>Quantità</th>
                    <th>Ingrediente</th>
                  </tr>
                </thead>
                <tbody>
                  {this.state.quantita.length !== 0 && this.state.quantita.map((rs, index) => (
                    <tr key={index} >
                      <td>{rs.frequenza}</td>
                      <td>{rs.parola}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
          </div>
          <div className="col-4" ></div>
        </div>
        </>
        )}
        <div className="row my-5">
          {this.state.prenotazione[0] && this.state.ripristina===false && (
            <>
            <div className="col-6">
                <button type="button" className="btn btn-outline-success btn-lg w-100 my-2" onClick={this.handlePrenotazione(1)}>ACCETTA</button>
            </div>
            <div className="col-6">
                <button type="button" className="btn btn-outline-danger btn-lg w-100 my-2" onClick={this.handlePrenotazione(0)}>RIFIUTA</button>
            </div>
            </>
          )}
          {this.state.prenotazione[0] && this.state.ripristina===true && (
            <>
            <div className="col-12">
                <button type="button" className="btn btn-outline-primary btn-lg w-100 my-2" onClick={this.handlePrenotazione(3)}>RIPRISTINA</button>
            </div>
            </>
          )}
        </div>
      </div>
      </>
    );
  }
}

export default DettagliPrenotazione;