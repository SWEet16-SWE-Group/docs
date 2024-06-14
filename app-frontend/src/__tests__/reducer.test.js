import { reducer } from '../helperFunctions/reducer.js';

describe('reducer', () => {
  it('should set timeArrival when action type is TIME', () => {
    const initialState = { timeArrival: '', cusineType: '' };
    const action = { type: 'TIME', payload: '12:00' };
    const newState = reducer(initialState, action);
    expect(newState).toEqual({ timeArrival: '12:00', cusineType: '' });
  });

  it('should set cusineType to pasta when action type is FILTER and payload is pasta', () => {
    const initialState = { timeArrival: '', cusineType: '' };
    const action = { type: 'FILTER', payload: 'pasta' };
    const newState = reducer(initialState, action);
    expect(newState).toEqual({ timeArrival: '', cusineType: 'pasta' });
  });

  it('should set cusineType to carne when action type is FILTER and payload is carne', () => {
    const initialState = { timeArrival: '', cusineType: '' };
    const action = { type: 'FILTER', payload: 'carne' };
    const newState = reducer(initialState, action);
    expect(newState).toEqual({ timeArrival: '', cusineType: 'carne' });
  });

  it('should set cusineType to pesce when action type is FILTER and payload is pesce', () => {
    const initialState = { timeArrival: '', cusineType: '' };
    const action = { type: 'FILTER', payload: 'pesce' };
    const newState = reducer(initialState, action);
    expect(newState).toEqual({ timeArrival: '', cusineType: 'pesce' });
  });

  it('should set cusineType to pizza when action type is FILTER and payload is pizza', () => {
    const initialState = { timeArrival: '', cusineType: '' };
    const action = { type: 'FILTER', payload: 'pizza' };
    const newState = reducer(initialState, action);
    expect(newState).toEqual({ timeArrival: '', cusineType: 'pizza' });
  });

  it('should set cusineType to empty string when action type is FILTER and payload is empty string', () => {
    const initialState = { timeArrival: '', cusineType: '' };
    const action = { type: 'FILTER', payload: '' };
    const newState = reducer(initialState, action);
    expect(newState).toEqual({ timeArrival: '', cusineType: '' });
  });

  it('should log an error for unknown action type', () => {
    console.log = jest.fn();
    const initialState = { timeArrival: '', cusineType: '' };
    const action = { type: 'UNKNOWN', payload: '' };
    reducer(initialState, action);
    expect(console.log).toHaveBeenCalledWith("something is wrong with reducer function");
  });

  it('should log an error for unknown filter payload', () => {
    console.log = jest.fn();
    const initialState = { timeArrival: '', cusineType: '' };
    const action = { type: 'FILTER', payload: 'unknown' };
    reducer(initialState, action);
    expect(console.log).toHaveBeenCalledWith("inner switch is acting up...");
  });
});
