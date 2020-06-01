<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $blog;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *  min = 1,
     *  max = 255,
     *  minMessage = "Le titre de l'article ne peut pas être vide",
     *  maxMessage = "Le titre de l'article ne peut pas faire plus de {{limit}} caractères"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *  min = 1,
     *  minMessage = "L'article ne peut pas être vide"
     * )
     */
    private $content;

    /**
     * @ORM\Column(type="text")
     * @Assert\File(
     *  mimeTypes = {"image/png", "image/jpeg", "image/jpg"},
     *  mimeTypesMessage = "Le format de votre fichier est invalide ({{type}}). Les formats autorisés sont {{types}}",
     *  maxSizeMessage = "Votre fichier est trop lourd ({{size}} {{suffix}}). Le poids maximum est de {{limit}} {{suffix}}"
     * )
     * @Assert\NotBlank(
     *  message = "L'article doit avoir une photo de couverture",
     *  groups = {"creation"}
     * )
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="article", orphanRemoval=true)
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlog(): ?int
    {
        return $this->blog;
    }

    public function setBlog(int $blog): self
    {
        $this->blog = $blog;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }

    //Fonction pour supprimer l'image à la suppression de l'article
    /**
    * @ORM\PostRemove
    */
    public function deleteFile() 
    {
        if(file_exists(__DIR__ . '/../../public/uploads/images/'.$this->image)) {
            unlink(__DIR__ . '/../../public/uploads/images/'.$this->image);
        }
        return true;
    }
}
