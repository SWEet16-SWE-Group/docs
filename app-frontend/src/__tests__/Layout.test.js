import React from 'react';
import { render, screen } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom';
import { useNavigate } from 'react-router-dom';
import { useStateContext } from '../contexts/ContextProvider';
import Layout from '../components/Layout';

jest.mock('react-router-dom', () => ({
  ...jest.requireActual('react-router-dom'),
  useNavigate: jest.fn(),
}));

jest.mock('../contexts/ContextProvider', () => ({
  useStateContext: jest.fn(),
}));

describe('Layout', () => {
  const navigate = jest.fn();

  beforeEach(() => {
    useNavigate.mockReturnValue(navigate);
  });

  const renderWithContext = (role, user, token) => {
    useStateContext.mockReturnValue({
      user,
      token,
      role,
      notification: null,
      notificationStatus: null,
      setUser: jest.fn(),
      setToken: jest.fn(),
      setRole: jest.fn(),
      setProfile: jest.fn(),
    });

    return render(
      <MemoryRouter>
        <Layout Content={<div>Test Content</div>} />
      </MemoryRouter>
    );
  };

  it('renders the default layout for ANONIMO role', () => {
    renderWithContext('ANONIMO', null, null);
    expect(screen.getByText(/Esplora/i)).toBeInTheDocument();
    expect(screen.getByText(/Login/i)).toBeInTheDocument();
    expect(screen.getByText(/Sign up/i)).toBeInTheDocument();
  });

  it('renders the authenticated layout for AUTENTICATO role', () => {
    renderWithContext('AUTENTICATO', 'test_user', 'test_token');
    expect(screen.getAllByText(/Profilo/i)[0]).toBeInTheDocument();
    expect(screen.getByText(/Selezione Profilo/i)).toBeInTheDocument();
    expect(screen.getByText(/Logout/i)).toBeInTheDocument();
  });

  it('renders the client layout for CLIENTE role', () => {
    renderWithContext('CLIENTE', 'test_user', 'test_token');
    expect(screen.getByText(/Prenota/i)).toBeInTheDocument();
    expect(screen.getByText(/Logout/i)).toBeInTheDocument();
    expect(screen.getByText(/Selezione Profilo/i)).toBeInTheDocument();
  });

  it('renders the restaurateur layout for RISTORATORE role', () => {
    renderWithContext('RISTORATORE', 'test_user', 'test_token');
    expect(screen.getByText(/Selezione Profilo/i)).toBeInTheDocument();
    expect(screen.getByText(/Logout/i)).toBeInTheDocument();
  });

  it('handles logout correctly', () => {
    const setUser = jest.fn();
    const setToken = jest.fn();
    const setRole = jest.fn();
    const setProfile = jest.fn();

    useStateContext.mockReturnValue({
      user: 'test_user',
      token: 'test_token',
      role: 'CLIENTE',
      notification: null,
      notificationStatus: null,
      setUser,
      setToken,
      setRole,
      setProfile,
    });

    render(
      <MemoryRouter>
        <Layout Content={<div>Test Content</div>} />
      </MemoryRouter>
    );

    screen.getByText(/Logout/i).click();

    expect(setUser).toHaveBeenCalledWith(null);
    expect(setToken).toHaveBeenCalledWith(null);
    expect(setProfile).toHaveBeenCalledWith(null);
    expect(setRole).toHaveBeenCalledWith('ANONIMO');
    expect(navigate).toHaveBeenCalledWith('/login');
  });
});
