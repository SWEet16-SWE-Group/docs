import { getFilteredData } from '../helperFunctions/getFilteredData.js';

describe('getFilteredData', () => {
  const data = [
    { cucina: "Pesce", ristorante: { orario: "09:00-22:00" } },
    { cucina: "Carne", ristorante: { orario: "11:00-23:00" } },
    { cucina: "Pasta", ristorante: { orario: "10:00-20:00" } },
    { cucina: "Pizza", ristorante: { orario: "12:00-22:00" } },
    { cucina: "Vegetariana", ristorante: { orario: "08:00-21:00" } }
  ];

  it('should filter by cuisine and hour', () => {
    const result = getFilteredData(data, 'pasta', '15:00');
    expect(result).toEqual([{ cucina: "Pasta", ristorante: { orario: "10:00-20:00" } }]);
  });

  it('should filter only by cuisine if no hour is provided', () => {
    const result = getFilteredData(data, 'pizza', '');
    expect(result).toEqual([{ cucina: "Pizza", ristorante: { orario: "12:00-22:00" } }]);
  });

  it('should return the original array if no filters are applied', () => {
    const result = getFilteredData(data, '', '');
    expect(result).toEqual(data);
  });

  it('should return an empty array if no ristoranti provided', () => {
    const result = getFilteredData(null, 'pesce', '15:00');
    expect(result).toEqual([]);
  });

  it('should filter correctly if hour is within the range', () => {
    const result = getFilteredData(data, 'carne', '12:00');
    expect(result).toEqual([{ cucina: "Carne", ristorante: { orario: "11:00-23:00" } }]);
  });

  it('should return an empty array if no restaurant matches the hour', () => {
    const result = getFilteredData(data, 'pasta', '21:00');
    expect(result).toEqual([]);
  });
});
