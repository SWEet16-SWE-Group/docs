export const getSortedData = (restaurants , sortBy) => {
    if (restaurants) {
        const bufferArr=[restaurants];
    switch (sortBy) {
      
      case "RATING_HIGH_TO_LOW":
        debugger;
        return restaurants.sort((a, b) => b.rating - a.rating);
        ;
      case "none":
        return bufferArr;
  
      default:
        console.log("something is wrong with getSortedData...");
        return bufferArr;
    }
} else {
    return [];
}
  };