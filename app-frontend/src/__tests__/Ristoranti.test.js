import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import axiosClient from '../axios-client';
import Ristoranti from '../views/Ristoranti.jsx';
import { MemoryRouter } from 'react-router-dom';

jest.mock('../axios-client');

const mockRistoranti = [
  { id: 1, nome: 'Ristorante A', cucina: 'Italiana', indirizzo: 'Via Roma 1', orario: '12:00-22:00' },
  { id: 2, nome: 'Ristorante B', cucina: 'Cinese', indirizzo: 'Via Milano 2', orario: '11:00-23:00' },
  { id: 3, nome: 'Ristorante C', cucina: 'Italiana', indirizzo: 'Via Napoli 3', orario: '10:00-20:00' }
];

describe('Ristoranti Component', () => {
  beforeEach(() => {
    axiosClient.get.mockResolvedValue({ data: mockRistoranti });
  });

  afterEach(() => {
    jest.clearAllMocks();
  });

  test('renders the component and fetches data', async () => {
    render(
      <MemoryRouter>
        <Ristoranti />
      </MemoryRouter>
    );

    expect(screen.getByText('Caricamento...')).toBeInTheDocument();

    await waitFor(() => {
      expect(axiosClient.get).toHaveBeenCalledWith('/ristoranti');
      expect(screen.getByText('Ristorante A')).toBeInTheDocument();
      expect(screen.getByText('Ristorante B')).toBeInTheDocument();
      expect(screen.getByText('Ristorante C')).toBeInTheDocument();
    });
  });

  test('filters restaurants by name', async () => {
    render(
      <MemoryRouter>
        <Ristoranti />
      </MemoryRouter>
    );

    await waitFor(() => {
      expect(screen.getByText('Ristorante A')).toBeInTheDocument();
    });

    fireEvent.change(screen.getByLabelText('Nome'), { target: { value: 'B' } });

    await waitFor(() => {
      expect(screen.queryByText('Ristorante A')).not.toBeInTheDocument();
      expect(screen.getByText('Ristorante B')).toBeInTheDocument();
      expect(screen.queryByText('Ristorante C')).not.toBeInTheDocument();
    });
  });

  test('filters restaurants by cuisine', async () => {
    render(
      <MemoryRouter>
        <Ristoranti />
      </MemoryRouter>
    );

    await waitFor(() => {
      expect(screen.getByText('Ristorante A')).toBeInTheDocument();
    });

    fireEvent.change(screen.getByLabelText('Cucina'), { target: { value: 'Italiana' } });

    await waitFor(() => {
      expect(screen.getByText('Ristorante A')).toBeInTheDocument();
      expect(screen.queryByText('Ristorante B')).not.toBeInTheDocument();
      expect(screen.getByText('Ristorante C')).toBeInTheDocument();
    });
  });

  test('displays message when no restaurants match the filters', async () => {
    render(
      <MemoryRouter>
        <Ristoranti />
      </MemoryRouter>
    );

    await waitFor(() => {
      expect(screen.getByText('Ristorante A')).toBeInTheDocument();
    });

    fireEvent.change(screen.getByLabelText('Nome'), { target: { value: 'X' } });

    await waitFor(() => {
      expect(screen.getByText('Nessun risultato corrisponde ai criteri scelti')).toBeInTheDocument();
    });
  });
});
