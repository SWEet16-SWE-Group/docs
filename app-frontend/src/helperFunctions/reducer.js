export const reducer = (state, action) => {
    switch (action.type) {
      case "SORT":
        return { ...state, sortBy: action.payload };
      case "TIME":
        return { ...state,
                 timeArrival : action.payload };
      case "FILTER":
        switch (action.payload) {
          case 'pasta':
            return {...state , cusineType : 'pasta' };
          case 'carne':
            return {...state , cusineType : 'carne' };
          case 'pesce':
            return {
              ...state,
              cusineType : 'pesce' 
            };
            case 'pizza':
            return {
              ...state,
             cusineType : 'pizza'
            }; 
            case '':
            return {
              ...state,
             cusineType : ''
            }; 
          default:
            console.log("inner switch is acting up...");
            break;
        }
        break;
      default:
        console.log("something is wrong with reducer function");
        break;
    }
  };