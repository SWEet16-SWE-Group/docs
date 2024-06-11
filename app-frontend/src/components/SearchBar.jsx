import {useState} from 'react';
import {useNavigate , useSearchParams} from 'react-router-dom';

export default function SearchBar() {

    const [searchQuery,setSearchQuery] = useState({
        città : '',
        ristorante : '',
    });
    const navigate=useNavigate();
    const [searchParams,setSearchParams] = useSearchParams();

    const handleChange = (e) => {
        setSearchQuery(
            {
                ...searchQuery,
               [e.target.name] : e.target.value,
            } 
        );
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        setSearchParams({q : searchQuery});
        navigate(`/search?città=${searchQuery.città}&ristorante=${searchQuery.ristorante}`);
    };

    return (
        <div>     
        <form onSubmit={handleSubmit} >
        <input list="città_disponibili" id="sceltaCittà" name="città" placeholder='Scegli una città!' onChange={handleChange} required/>

<datalist id="città_disponibili">
  <option value="Milano"></option>
  <option value="Padova"></option>
  <option value="Bologna"></option>
  <option value="Firenze"></option>
  <option value="Napoli"></option>
</datalist>
        <input
          id="searchBar"
          type="text"
          name="ristorante"
          onChange={handleChange}
          placeholder='Scegli un ristorante!'
        />
        <button >Cerca</button>
        </form>
      </div>
    );
}