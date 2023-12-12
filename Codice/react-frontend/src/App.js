import './App.css';

import Navbar from './components/navbar.js';
import ListRistoranti from './components/list_ristoranti.js';
import SignInCliente from './components/new_cliente.js';
import UpdateCliente from './components/edit_cliente.js';

function App() {
  return (
    <>
    <Navbar />
    <ListRistoranti />
    <SignInCliente />
    <UpdateCliente />
    </>
  );
}

export default App;
