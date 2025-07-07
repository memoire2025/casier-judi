import React from 'react';
import logonew from './../../assets/img/logo.png';
import {Link, useNavigate} from "react-router-dom";
import { Navbar, Container, Row, Col, Nav, Image } from 'react-bootstrap';

export default function MainDesign ({children}) {

    let userInfo = JSON.parse(localStorage.getItem('userInfo-casier'));
    const navigate = useNavigate();
    
    const HandleLogout = async (e) => {
        e.preventDefault();
        localStorage.removeItem("accessToken-casier");
        localStorage.removeItem('userInfo-casier');
        navigate('/login');  
    }
       
    return (
        <>
            <Row className='w-100 position-relative'>
                <Col className='navigation p-0'>
                    <Container className='pt-3 p-0 text-center h-100'>

                        <Navbar.Brand className='text-white fw-bold mt-3'><Image src={logonew} width={80} /></Navbar.Brand>
                        <hr className='text-white' />
                        <Nav className='nav-princ text-start mt-5 position-relative'>
                            <Nav.Link as={Link}  to="/home" className='nav-links active'> <ion-icon name="home"></ion-icon> Tableau de bord</Nav.Link>
                            <Nav.Link as={Link} to="/casier" className='nav-links'> <ion-icon name="people"></ion-icon> Gestion casier</Nav.Link>
                            <Nav.Link as={Link} to="/indetification" className='nav-links'> <ion-icon name="scan-circle"></ion-icon> Vérification</Nav.Link>
                            {
                                userInfo.poste === "admin" ? <Nav.Link as={Link} to="/agent" className='nav-links'><ion-icon name="person"></ion-icon> Agents </Nav.Link> : ''
                            }
                            <Nav.Link as={Link} onClick={HandleLogout} className='nav-links rounded-0'> <ion-icon name="log-out"></ion-icon> Deconnexion</Nav.Link>
                        </Nav>

                    </Container>
                </Col>
                <Col className='main bg-opacity-25'>
                    <Row className='justify-content-center mb-3 py-2 border-bottom bg-white sticky-top' style={{ width : '103.7%'}}>
                        <Image src={logonew} style={{width : '80px'}} />
                    </Row>
                    <Row>
                        {children}
                    </Row>
                </Col>
            </Row>
        </>
    );
}