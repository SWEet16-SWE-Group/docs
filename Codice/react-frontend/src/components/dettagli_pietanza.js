import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';

import Navbar from './navbar';

class DettagliPietanza extends Component {
  constructor(props) {
    super(props);
    this.state = {
        prenotazione: [],
        pietanza: [],
        ingredienti: [],
        rimossi: [],
        quantita: 1
    };
    this.handleSubmit = this.handleSubmit.bind(this);
    this.handleNumberChange = this.handleNumberChange.bind(this);
    this.handleCheckboxChange = this.handleCheckboxChange.bind(this);
   }

   componentDidMount() {
    let pathname = window.location.pathname;
    let id_prodotto = pathname.split('/')[2];
    let id_prenotazione = -1;
    if (localStorage && localStorage.getItem('idp')) { id_prenotazione = JSON.parse(localStorage.getItem('idp')) }

    axios.post("http://localhost:8888/select_prenotazione.php ", {id_prenotazione}).then(response =>
      this.setState({ prenotazione: response.data }))
    axios.post('http://localhost:8888/select_single_prodotto.php', { id_prodotto }).then(response => {
        const ingredientiArray=response.data[0].Ingredienti.split(',').map(ingrediente => ingrediente.trim())
        this.setState({ pietanza: response.data, ingredienti: ingredientiArray });
    })
  }

  handleNumberChange = (event) => {
    let num = event.target.value;
    this.setState({quantita: num});
  }

  handleCheckboxChange = (event) => {
    const nome = event.target.value;
    const { rimossi } = this.state;

    if (rimossi.includes(nome)) {
      this.setState({ rimossi: rimossi.filter((name) => name !== nome) });
    } else {
      this.setState({ rimossi: [...rimossi, nome] });
    }
  };

  handleSubmit = (event) => {

    event.preventDefault();

    const cliente = JSON.parse(localStorage.getItem('idc'));
    const prenotazione = this.state.prenotazione[0].ID_prenotazione;
    const prodotto = this.state.pietanza[0].ID_prodotto;
    const porzioni = this.state.quantita;
    const tot = this.state.pietanza[0].Prezzo * porzioni;
    const rimossi = this.state.rimossi.join(', ')


    const insert = [
      {
        id_cliente: cliente,
        id_prenotazione: prenotazione,
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
        <div className="container-fluid p-auto w-75 border rounded border-2 margin-tb gx-0">
          <form className="row gx-0 d-flex justify-content-center" onSubmit={this.handleSubmit}>
            {this.state.pietanza && this.state.pietanza.map((rs, index) => (
            <div key={index}>
                <img className="card-img-top h-50" src ={`data:image/jpeg;base64,${rs.Immagine}`} alt={rs.Nome_Immagine}/>
              <div className="mt-5">
                <h3 className="card-title text-center my-4">{rs.Nome}</h3>
                <p className="card-text text-center my-4">{rs.Descrizione}</p>
                <div className="row justify-content-center mb-3">
                  <input type="number" className="form-control w-25 text-center" name={"quantita" + rs.Nome} id={"quantita" + rs.Nome} min="1" defaultValue="1" onChange={this.handleNumberChange}/>
                </div>
                <h5 className="card-text text-center my-4">€{rs.Prezzo}</h5>
                <p className="card-text text-center my-4">Allergeni: {rs.Allergeni}</p>
                <div className="text-center my-4">
                  <div className="row my-4">
                    <div className="col-4 my-4"></div>
                    <div className="col-4 my-4">
                      <label htmlFor="ingredienti" className="mb-2">Rimuovi eventuali ingredienti:</label>
                      {this.state.ingredienti && this.state.ingredienti.map((rs, index) => (
                        <div className="text-start" key={index}>
                          <input type="checkbox" className="form-check-input mb-2 mr-1" id="ingredienti" name="ingredienti" value={rs} onChange={this.handleCheckboxChange}/> <label htmlFor="ingredienti" className="text-break">{rs}</label>
                        </div>
                      ))}
                    </div>
                    <div className="col-4 my-4"></div>
                  </div>
                </div>
              </div>
            </div>
            ))}

            <div className="mt-5 d-flex justify-content-center">
                <Link to="/menu" className="btn btn-outline-primary btn-outline btn-lg w-100 m-2">TORNA AL MENU</Link>
            </div>
                <div className="d-flex justify-content-center">
                  <button type="submit" className="btn btn-primary btn-lg w-100 m-2">AGGIUNGI</button>
                </div>
                </form>
        </div>
      </>
    );
  }
}

export default DettagliPietanza;