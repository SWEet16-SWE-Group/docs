const getCusineFilteredData = (ristoranti, selectCusine) => {
  if (ristoranti) {
    const bufferArr = [...ristoranti];
    switch (selectCusine) {
      case 'pesce':
        
        return bufferArr.filter((item) => item.cucina === "Pesce");
      case 'carne':
        
        return bufferArr.filter((item) => item.cucina === "Carne");
      case 'pasta':
        return bufferArr.filter((item) => item.cucina === "Pasta");
      case 'pizza':
        return bufferArr.filter((item) => item.cucina === "Pizza");
      case  '' :
          return bufferArr; 
      default:
        console.log("Non è possibile selezionare il tipo di cucina!");
        break;
    }
  } else {
    return ([]);
  }
  }
  export const getFilteredData = (
    ristoranti,
    selectCusine,
    selectHour
  ) => {
    const bufferArr = getCusineFilteredData(ristoranti,selectCusine);
    console.log(selectHour);
    let results=[];
    if(selectHour) {
      results = bufferArr.filter((item)=>{
        console.log(item.ristorante.orario);
        const [openingTime,closingTime] = item.ristorante.orario.split("-").map(time => time.trim());;
        console.log([openingTime,closingTime]);
        return selectHour >= openingTime && selectHour <= closingTime;
      });
      console.log(results);
      return results;
    }
    return bufferArr;
  }
  
  
  