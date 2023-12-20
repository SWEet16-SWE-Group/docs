import React, { Component } from 'react';
import { Carousel } from 'react-bootstrap';
import axios from 'axios';

class FormPrenotazione extends Component {
  constructor(props) {
    super(props);
    this.state = {
      ristoranti: [],
      ristorantifiltrati: [],
      cerca: ""
    };
    this.filterList = this.filterList.bind(this);
    this.onChange = this.onChange.bind(this);
  }

  componentDidMount() {
    axios.get('http://localhost:8888/select_multiple_ristorante.php').then(response =>
      this.setState({ ristoranti: response.data}));
  }

  onChange(event) {
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

  render() {

    return (
        <form>
        <Carousel className="container-fluid p-auto w-75 border rounded margin-top" autoPlay={false} interval={null} controls={true} indicators={true}>
    
          <Carousel.Item>
            <h1 className="my-4 d-flex justify-content-center">PRENOTAZIONE</h1>
                            <div className="m-5">
                              <label htmlFor="ricerca">Trova un ristorante:</label>
                              <input type="text" className="form-control mb-3" name="ricerca" id="ricerca" placeholder="Cerca" value={this.state.cerca} onChange={this.onChange}/>
                              {this.state.ristorantifiltrati.map((rs, index) => (
                              <div key={index}>
                                <input type="radio" className="mb-2 mr-1" id={rs.Ragione_sociale + "_seleziona"} name="seleziona_rist" value={rs.Ragione_sociale} /> <label htmlFor={rs.Ragione_sociale + "_seleziona"}>{rs.Ragione_sociale}</label>
                              </div>
                              ))}
                            </div>
          </Carousel.Item>
          <Carousel.Item>
            <h1 className="my-4 d-flex justify-content-center">REAL TIME UPDATE</h1>
                            <div className="m-5">
                            <label htmlFor="username">Modifica nome utente:</label>
                            <input type="text" className="form-control" name="username" id="username" placeholder="" autoComplete="on" defaultValue=""  />
                            </div>
                            <div className="m-5">
                            <label htmlFor="email">Modifica la email:</label>
                            <input type="email"  className="form-control" name="email" id="email" placeholder="" autoComplete="on" defaultValue="" />
                            </div>
                            <div  className="m-5">
                            <label htmlFor="password">Modifica la password:</label>
                            <input type="password" className="form-control" name="password" id="password" placeholder="" autoComplete="on" defaultValue="" />
                            </div>
          </Carousel.Item>
          </Carousel>
        </form>
      );
    }
}
    
export default FormPrenotazione;