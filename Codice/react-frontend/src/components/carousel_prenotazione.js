import React, { Component } from 'react';
import { Carousel } from 'react-bootstrap';
import axios from 'axios';

class FormPrenotazione extends Component {
  constructor(props) {
    super(props);
    this.state = {
      ristoranti: [],
      ristorantifiltrati: [],
      ristoranteselezionato: [],
      cerca: "",
      numeropersone: "",
      page: 0
    };
    this.filterList = this.filterList.bind(this);
    this.handleSearch = this.handleSearch.bind(this);
    this.handleRadioChange = this.handleRadioChange.bind(this);
    this.handleNumberChange = this.handleNumberChange.bind(this);
  }

  componentDidMount() {
    axios.get('http://localhost:8888/select_multiple_ristorante.php').then(response =>
      this.setState({ ristoranti: response.data}));
  }

  handleSelect = (selectedPage) => {
    this.setState({ page: selectedPage });
  };

  handleSearch = (event) => {
    const cerca = event.target.value.toLowerCase();
    this.setState({ cerca }, () => this.filterList());
  }

  filterList() {
    let ristoranti = this.state.ristoranti;
    let cerca = this.state.cerca;

    ristoranti = ristoranti.filter(function(ristoranti) {
      return ristoranti.Ragione_sociale.toLowerCase().indexOf(cerca) !== -1;
    });
    this.setState({ ristorantifiltrati: ristoranti });
  }

  handleRadioChange = (event) => { 
    let id = event.target.value;
    this.state.ristoranteselezionato[0] = this.state.ristoranti[id];
    document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
  }

  handleNumberChange = (event) => {
    let num = event.target.value;
    this.setState({ numeropersone: num });
    document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
  }

  render() {
    const { page } = this.state;
      if(document.getElementsByClassName("carousel-control-prev")[0] && document.getElementsByClassName("carousel-control-next")[0])
      {
      if(page === 0)
      {
        document.getElementsByClassName("carousel-control-prev")[0].style.display="none";
        document.getElementsByClassName("carousel-control-next")[0].style.display="none";
      }
      if(page === 1 || page=== 2)
      {
        document.getElementsByClassName("carousel-control-prev")[0].style.display="flex";
        document.getElementsByClassName("carousel-control-next")[0].style.display="none";
        
      }
    }
    return (
        <form>
        <Carousel activeIndex={page} onSelect={this.handleSelect} className="container-fluid p-auto w-75 border rounded border-2 margin-top" style={{height : "500px"}} autoPlay={false} interval={null} controls={true} indicators={false}>
          <Carousel.Item>
            <h1 className="my-4 d-flex justify-content-center">PRENOTAZIONE</h1>
                            <div className="m-5">
                              <label htmlFor="ricerca">Trova un ristorante:</label>
                              <input type="text" className="form-control mb-3" name="ricerca" id="ricerca" placeholder="Cerca" value={this.state.cerca} onChange={this.handleSearch}/>
                              {this.state.ristorantifiltrati.map((rs, index) => (
                              <div key={index}>
                                <input type="radio" className="mb-2 mr-1" id="seleziona_rist" name="seleziona_rist" value={index} onClick={this.handleRadioChange}/> <label htmlFor={rs.Ragione_sociale + "_seleziona"}>{rs.Ragione_sociale}</label>
                              </div>
                              ))}
                            </div>
          </Carousel.Item>
          <Carousel.Item>
            <h1 className="my-4 d-flex justify-content-center">PRENOTAZIONE</h1>
                            <div className="m-5">
                              <label htmlFor="num_persone">Seleziona il numero di persone:</label>
                              <input type="number" className="form-control" name="num_persone" id="num_persone" min="1" onChange={this.handleNumberChange} />
                            </div>
          </Carousel.Item>
          <Carousel.Item>
            <h1 className="my-4 d-flex justify-content-center">PRENOTAZIONE</h1>
                          {this.state.ristoranteselezionato.map((rs, index) => (
                            <div key={index}>
                                <div className="m-5">
                                <label htmlFor="data_prenotazione">Seleziona il giorno:</label>
                                <input type="date" className="form-control" name="data_prenotazione" id="data_prenotazione" />
                                </div>
                                <div className="m-5">
                                <label htmlFor="ora_arrivo">Seleziona l'ora di arrivo:</label>
                                <input type="time" className="form-control" name="ora_arrivo" id="ora_arrivo" step="3600" />
                                </div>
                                <div  className="m-5">
                                <label htmlFor="ora_partenza">Seleziona l'ora di partenza:</label>
                                <input type="time" className="form-control" name="ora_partenza" id="ora_partenza" />
                                </div>
                              </div>
                          ))}
          </Carousel.Item>
          </Carousel>
        </form>
      );
    }
}
    
export default FormPrenotazione;