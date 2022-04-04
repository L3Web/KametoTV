<?php

namespace App\Controller\cart;


use App\Controller\Controller;
use App\Entity\Commande;
use App\Entity\User;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class CartController extends Controller
{

    private SessionInterface $session;
    private ProductRepository $productRepository;

    #[Pure] public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack, ProductRepository $productRepository)
    {
        parent::__construct($entityManager);
        $this->session = $requestStack->getSession();
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/panier", name="app_cart")
     */
    public function cart()
    {
        $cart = $this->session->get('panier');
        $cartData = [];
        if ($cart !== null) {
            foreach ($cart as $id => $quantity) {
                $cartData [] = [
                    'product' => $this->productRepository->find($id),
                    'quantity' => $quantity
                ];
            }
        }
        $total = $this->session->get("total");

        return $this->render('cart/cart.html.twig', [
            'items' => $cartData,
            'total' => $total
        ]);
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/panier/add/{id<^[1-9]{1}[0-9]*$>}", name="app_cart_add")
     */
    public function add(int $id)
    {
        $cart = $this->session->get('panier');

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        $this->session->set('panier', $cart);
        $product = $this->productRepository->findOneBy(array("id" => $id));
        $this->changePrice("+", $product->getPrice());

        return $this->redirectToRoute('app_boutique');
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/panier/remove/{id<^[1-9]{1}[0-9]*$>}", name="app_cart_remove")
     */
    public function remove(int $id)
    {
        $cart = $this->session->get('panier');
        $product = $this->productRepository->findOneBy(array("id" => $id));

        if (!empty($cart[$id])) {
            $this->changePrice("-", $product->getPrice() * $cart[$id]);
            unset($cart[$id]);
        }
        $this->session->set('panier', $cart);

        return $this->redirectToRoute("app_cart");
    }


    /**
     * @Route("/{_locale<%app.supported_locales%>}/account/commander", name="app_commander")
     *
     */
    public function commander(UserRepository $userRepository, UserInterface $user): Response
    {
        $cart = $this->session->get("panier");
        $this->setCommande($cart, $this->session->get("total"), ($userRepository->findOneBy(array("id" => $user->getId()))));
        $this->session->set("panier", []);
        $this->session->set("total", 0);

        return $this->redirectToRoute('app_base_home');
    }


    private function changePrice(string $type, int $value): void
    {
        if ($type === "+") {
            $this->session->set('total', $this->session->get("total") + $value);
        } else {
            $this->session->set('total', $this->session->get("total") - $value);
        }
    }

    private function setCommande(array $products, int $total, User $user): void
    {
        $commande = new Commande();
        $commande->setArticles($products);
        $commande->setDate(new \DateTimeImmutable("now"));
        $commande->setTotal($total);
        $commande->setIdUser($user);
        $commande->setStatus(0);

        $this->entityManager->persist($commande);
        $this->entityManager->flush();
    }
}