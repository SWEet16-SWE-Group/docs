import React from 'react';
import { render, screen, fireEvent } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom';
import SearchBar from '../components/SearchBar';

const mockNavigate = jest.fn();
const mockSetSearchParams = jest.fn();

jest.mock('react-router-dom', () => ({
  ...jest.requireActual('react-router-dom'),
  useNavigate: () => mockNavigate,
  useSearchParams: () => [new URLSearchParams(), mockSetSearchParams],
}));

describe('SearchBar', () => {
  it('updates input values correctly', () => {
    render(
      <MemoryRouter>
        <SearchBar />
      </MemoryRouter>
    );

    const cittaInput = screen.getByPlaceholderText('Scegli una città!');
    const ristoranteInput = screen.getByPlaceholderText('Scegli un ristorante!');

    fireEvent.change(cittaInput, { target: { value: 'Milano' } });
    fireEvent.change(ristoranteInput, { target: { value: 'Test Ristorante' } });

    expect(cittaInput.value).toBe('Milano');
    expect(ristoranteInput.value).toBe('Test Ristorante');
  });

  it('navigates to the correct URL on form submission', () => {
    render(
      <MemoryRouter>
        <SearchBar />
      </MemoryRouter>
    );

    const cittaInput = screen.getByPlaceholderText('Scegli una città!');
    const ristoranteInput = screen.getByPlaceholderText('Scegli un ristorante!');
    const searchButton = screen.getByText('Cerca');

    fireEvent.change(cittaInput, { target: { value: 'Milano' } });
    fireEvent.change(ristoranteInput, { target: { value: 'Test Ristorante' } });
    fireEvent.click(searchButton);

    expect(mockSetSearchParams).toHaveBeenCalledWith({ q: { città: 'Milano', ristorante: 'Test Ristorante' } });
    expect(mockNavigate).toHaveBeenCalledWith('/search?città=Milano&ristorante=Test Ristorante');
  });
});
